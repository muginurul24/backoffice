<?php

namespace App\Livewire\Table;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class BankList extends Component
{
    use WithPagination;

    /** Filters */
    public string $search = '';
    public string $bankTypeFilter = 'all';

    /** Modal state */
    public bool $showEditModal = false;

    /** Jika null = CREATE, jika instance Payment = EDIT */
    public ?Payment $editing = null;

    /** Form fields (modal) */
    public string $bank_name = '';
    public string $bank_type = '';
    public string $account_number = '';
    public string $account_name = '';
    public bool $status = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'bankTypeFilter' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

    /** Sama persis dengan enum di migration */
    private const BANK_NAMES = [
        'QRIS',
        'TELKOMSEL', 'XL',
        'BTC', 'USDT', 'BNB', 'SOL', 'XRP',
        'BCA', 'BNI', 'BRI', 'BSI', 'CIMB', 'MANDIRI', 'PERMATA', 'JAGO', 'SEABANK', 'NEOBANK',
        'DANA', 'OVO', 'GOPAY', 'LINKAJA', 'SAKUKU', 'SHOPEEPAY',
    ];

    private const BANK_TYPES = [
        'qris' => 'QRIS',
        'pulsa' => 'Pulsa',
        'crypto' => 'Crypto',
        'bank' => 'Bank Transfer',
        'wallet' => 'E-Wallet',
    ];

    /** Reset pagination kalau filter berubah */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedBankTypeFilter(): void
    {
        $this->resetPage();
    }

    protected function rules(): array
    {
        return [
            'bank_name' => ['required', Rule::in(self::BANK_NAMES)],
            'bank_type' => ['required', Rule::in(array_keys(self::BANK_TYPES))],
            'account_number' => ['required', 'string', 'max:100'],
            'account_name' => ['required', 'string', 'max:100'],
            'status' => ['required', 'boolean'],
        ];
    }

    /** Dropdown filter type */
    public function getBankTypeOptionsProperty(): array
    {
        return ['all' => 'All Types'] + self::BANK_TYPES;
    }

    /** ========== CREATE MODE ========== */
    public function create(): void
    {
        $this->editing = null;

        $this->bank_name = '';
        $this->bank_type = '';
        $this->account_number = '';
        $this->account_name = '';
        $this->status = true;

        $this->resetValidation();
        $this->showEditModal = true;
    }

    /** ========== EDIT MODE ========== */
    public function edit(Payment $payment): void
    {
        $user = Auth::user();

        // Safety: pastikan ini benar-benar milik site user
        if ($payment->site_id !== $user?->site_id) {
            abort(403);
        }

        $this->editing = $payment;
        $this->bank_name = $payment->bank_name;
        $this->bank_type = $payment->bank_type;
        $this->account_number = $payment->account_number;
        $this->account_name = $payment->account_name;
        $this->status = (bool)$payment->status;

        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function closeModal(): void
    {
        $this->showEditModal = false;
        $this->editing = null;
        $this->resetValidation();
    }

    /** ========== CREATE / UPDATE ==========
     *  Kalau $editing null -> create
     *  Kalau $editing ada -> update
     */
    public function savePayment(): void
    {
        $this->validate();

        $user = Auth::user();

        $data = [
            'bank_name' => $this->bank_name,
            'bank_type' => $this->bank_type,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
            'status' => $this->status,
        ];

        if ($this->editing) {
            // UPDATE
            if ($this->editing->site_id !== $user?->site_id) {
                abort(403);
            }

            $this->editing->update($data);
            $message = 'Payment channel updated successfully ✅';
        } else {
            // CREATE
            $data['site_id'] = $user?->site_id;
            $data['user_id'] = $user?->id;

            $this->editing = Payment::create($data);
            $message = 'Payment channel created successfully ✅';
        }

        $this->showEditModal = false;
        $this->editing = null;

        session()->flash('success', $message);
    }

    /** ========== INLINE TOGGLE STATUS ========== */
    public function toggleStatus(Payment $payment): void
    {
        $user = Auth::user();

        if ($payment->site_id !== $user?->site_id) {
            abort(403);
        }

        $payment->update([
            'status' => !(bool)$payment->status,
        ]);
    }

    public function render(): View
    {
        $user = Auth::user();

        $query = Payment::query()
            ->where('site_id', $user?->site_id);

        $search = trim($this->search);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('bank_name', 'like', "%{$search}%")
                    ->orWhere('account_name', 'like', "%{$search}%")
                    ->orWhere('account_number', 'like', "%{$search}%");
            });
        }

        if ($this->bankTypeFilter !== 'all') {
            $query->where('bank_type', $this->bankTypeFilter);
        }

        $payments = $query
            ->latest()
            ->paginate(10);

        return view('livewire.table.bank-list', [
            'payments' => $payments,
            'typeLabels' => self::BANK_TYPES,
        ]);
    }
}
