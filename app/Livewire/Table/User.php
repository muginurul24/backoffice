<?php

namespace App\Livewire\Table;

use App\Models\Bank;
use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    /** Filters */
    public string $search = '';
    public string $kycFilter = 'all';
    public string $statusFilter = 'all';

    /** Modal */
    public bool $showModal = false;
    public ?Player $editing = null;

    /** Player fields */
    public string $username = '';
    public string $ext_username = '';
    public string $email = '';
    public string $phone = '';
    public ?string $upline = null;
    public string $status_kyc = 'inactive';
    public bool $status = true;

    public array $banks = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'kycFilter' => ['except' => 'all'],
        'statusFilter' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

    private const BANK_NAMES = [
        'BCA', 'BNI', 'BRI', 'BSI', 'CIMB', 'MANDIRI', 'PERMATA', 'JAGO', 'SEABANK', 'NEOBANK',
        'DANA', 'OVO', 'GOPAY', 'LINKAJA', 'SAKUKU', 'SHOPEEPAY',
    ];

    private const BANK_TYPES = [
        'bank' => 'Bank',
        'wallet' => 'E-Wallet',
    ];

    private const KYC_STATUSES = [
        'active' => 'Active',
        'pending' => 'Pending',
        'inactive' => 'Inactive',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedKycFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function getKycOptionsProperty(): array
    {
        return ['all' => 'All KYC'] + self::KYC_STATUSES;
    }

    public function getStatusOptionsProperty(): array
    {
        return [
            'all' => 'All Status',
            'active' => 'Active',
            'inactive' => 'Inactive',
        ];
    }

    protected function rules(): array
    {
        $playerId = $this->editing?->id;

        return [
            'username' => ['required', 'string', 'max:100'],
            'ext_username' => ['required', 'string', 'max:100', Rule::unique('players', 'ext_username')->ignore($playerId)],
            'email' => ['required', 'email', 'max:120', Rule::unique('players', 'email')->ignore($playerId)],
            'phone' => ['required', 'string', 'max:30', Rule::unique('players', 'phone')->ignore($playerId)],
            'upline' => ['nullable', 'string', 'max:100'],
            'status_kyc' => ['required', Rule::in(array_keys(self::KYC_STATUSES))],
            'status' => ['required', 'boolean'],
            'banks' => ['array'],
            'banks.*.id' => ['nullable', 'integer'],
            'banks.*._delete' => ['boolean'],
            'banks.*.bank_name' => ['nullable', Rule::in(self::BANK_NAMES)],
            'banks.*.bank_type' => ['nullable', Rule::in(array_keys(self::BANK_TYPES))],
            'banks.*.account_number' => ['nullable', 'string', 'max:100'],
            'banks.*.account_name' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function edit(Player $player): void
    {
        $siteId = Auth::user()?->site_id;

        if ($player->site_id !== $siteId) abort(403);

        $player->loadMissing('banks');

        $this->editing = $player;

        $this->username = $player->username;
        $this->ext_username = $player->ext_username;
        $this->email = $player->email;
        $this->phone = $player->phone;
        $this->upline = $player->upline;
        $this->status_kyc = $player->status_kyc;
        $this->status = (bool)$player->status;

        $this->banks = $player->banks
            ->sortBy('id')
            ->map(fn($b) => [
                'id' => $b->id,
                'bank_name' => $b->bank_name,
                'bank_type' => $b->bank_type,
                'account_number' => $b->account_number,
                'account_name' => $b->account_name,
                '_delete' => false,
            ])
            ->values()
            ->toArray();

        $this->resetValidation();
        $this->showModal = true;
    }

    public function addBank(): void
    {
        $this->banks[] = [
            'id' => null,
            'bank_name' => '',
            'bank_type' => 'bank',
            'account_number' => '',
            'account_name' => '',
            '_delete' => false,
        ];
    }

    public function removeBank(int $index): void
    {
        if (!isset($this->banks[$index])) return;

        // existing -> mark delete
        if (!empty($this->banks[$index]['id'])) {
            $this->banks[$index]['_delete'] = true;
            return;
        }

        // new -> remove from array
        unset($this->banks[$index]);
        $this->banks = array_values($this->banks);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->editing = null;
        $this->resetValidation();
    }

    /**
     * @throws \Throwable
     */
    public function save(): void
    {
        if (!$this->editing) return;

        $this->validate();

        $siteId = Auth::user()?->site_id;

        if ($this->editing->site_id !== $siteId) abort(403);

        DB::transaction(function () use ($siteId) {

            $this->editing->update([
                'username' => $this->username,
                'ext_username' => $this->ext_username,
                'email' => $this->email,
                'phone' => $this->phone,
                'upline' => $this->upline,
                'status_kyc' => $this->status_kyc,
                'status' => $this->status,
            ]);

            // Ownership guard for bank ids
            $existingIds = $this->editing->banks()->pluck('id')->all();

            foreach ($this->banks as $row) {
                $id = $row['id'] ?? null;

                // delete
                if (!empty($row['_delete']) && $id) {
                    if (in_array($id, $existingIds, true)) {
                        Bank::where('id', $id)->delete();
                    }
                    continue;
                }

                // skip empty row
                $filled = trim((string)($row['bank_name'] ?? '')) !== ''
                    || trim((string)($row['account_number'] ?? '')) !== ''
                    || trim((string)($row['account_name'] ?? '')) !== '';

                if (!$filled) continue;

                // enforce required if row is filled
                if (
                    empty($row['bank_name']) ||
                    empty($row['bank_type']) ||
                    empty($row['account_number']) ||
                    empty($row['account_name'])
                ) {
                    // lempar error validation manual biar jelas
                    $this->addError('banks', 'Ada baris bank yang belum lengkap (bank/type/number/name).');
                    throw new \RuntimeException('Incomplete bank row');
                }

                // update
                if ($id && in_array($id, $existingIds, true)) {
                    Bank::where('id', $id)->update([
                        'bank_name' => $row['bank_name'],
                        'bank_type' => $row['bank_type'],
                        'account_number' => $row['account_number'],
                        'account_name' => $row['account_name'],
                    ]);
                    continue;
                }

                // create
                Bank::create([
                    'player_id' => $this->editing->id,
                    'bank_name' => $row['bank_name'],
                    'bank_type' => $row['bank_type'],
                    'account_number' => $row['account_number'],
                    'account_name' => $row['account_name'],
                ]);
            }
        });

        $this->showModal = false;
        $this->editing = null;

        session()->flash('success', 'Player updated successfully ✅');
    }

    public function render(): View
    {
        $siteId = Auth::user()?->site_id;

        $query = Player::query()
            ->where('site_id', $siteId)
            ->with(['banks' => fn($q) => $q->orderByDesc('id')]);

        $search = trim($this->search);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('ext_username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($this->kycFilter !== 'all') {
            $query->where('status_kyc', $this->kycFilter);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter === 'active');
        }

        $players = $query->latest()->paginate(10);

        return view('livewire.table.user', [
            'players' => $players,
            'kycLabels' => self::KYC_STATUSES,
            'bankTypeLabels' => self::BANK_TYPES,
        ]);
    }
}
