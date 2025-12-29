<div>
    <section
        class="relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:bg-neutral-950/90">
        <x-placeholder-pattern
            class="pointer-events-none absolute inset-0 size-full stroke-gray-900/5 dark:stroke-neutral-100/5"/>

        <div class="relative space-y-4">
            {{-- Header + Filters --}}
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-neutral-600 dark:text-neutral-400">
                        Players
                    </h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-500">
                        List player + bank / e-wallet yang terdaftar pada site ini.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                    <div class="relative sm:min-w-[240px]">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search username / email / phone..."
                            class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                        >
                        <span
                            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-neutral-400">
                            <flux:icon.search variant="micro"/>
                        </span>
                    </div>

                    <select
                        wire:model.live="kycFilter"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                        @foreach($this->kycOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    <select
                        wire:model.live="statusFilter"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                        @foreach($this->statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-800 dark:border-emerald-800/60 dark:bg-emerald-950/60 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div
                class="overflow-hidden rounded-xl border border-neutral-200/80 bg-white/90 dark:border-neutral-800 dark:bg-neutral-950/80">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800 text-sm">
                        <thead class="bg-neutral-50/80 dark:bg-neutral-900/80">
                        <tr>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                #
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Player
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Contact
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Bank
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                KYC
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Status
                            </th>
                            <th class="px-4 py-2.5 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-200/80 dark:divide-neutral-800">
                        @forelse($players as $key => $player)
                            @php $bank = $player->banks->first(); @endphp
                            <tr wire:key="player-row-{{ $player->id }}"
                                class="hover:bg-neutral-50/80 dark:hover:bg-neutral-900/60">
                                <td class="px-4 py-2.5 align-top">
                                    <div class="flex flex-col">
                                        {{ $key + 1 }}
                                    </div>
                                </td>
                                <td class="px-4 py-2.5 align-top">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-neutral-900 dark:text-neutral-50">
                                            {{ $player->username }}
                                        </span>
                                        <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                            EXT: {{ $player->ext_username }}
                                        </span>
                                        @if($player->upline)
                                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                                Upline: {{ $player->upline }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-2.5 align-top">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-neutral-900 dark:text-neutral-50">
                                            {{ $player->email }}
                                        </span>
                                        <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                            {{ $player->phone }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-4 py-2.5 align-top">
                                    @if($bank)
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-neutral-900 dark:text-neutral-50">
                                                {{ $bank->bank_name }} · {{ strtoupper($bank->bank_type) }}
                                            </span>
                                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                                {{ $bank->account_number }} — {{ $bank->account_name }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">No bank data</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2.5 align-top">
                                    @php
                                        $kycClass = match($player->status_kyc) {
                                            'active' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200',
                                            'pending' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-200',
                                            default => 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium {{ $kycClass }}">
                                        {{ strtoupper($player->status_kyc) }}
                                    </span>
                                </td>

                                <td class="px-4 py-2.5 align-top">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                        {{ $player->status
                                            ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200'
                                            : 'bg-red-50 text-red-700 dark:bg-red-900/40 dark:text-red-200' }}">
                                        {{ $player->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td class="px-4 py-2.5 align-top text-right">
                                    <button
                                        type="button"
                                        wire:click="edit({{ $player->id }})"
                                        class="inline-flex items-center rounded-lg border border-neutral-300 px-2.5 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-900"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-4 py-6 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                    Belum ada player di site ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($players->hasPages())
                    <div
                        class="border-t border-neutral-200/80 bg-neutral-50/80 px-4 py-2.5 text-xs text-neutral-500 dark:border-neutral-800 dark:bg-neutral-900/80 dark:text-neutral-400">
                        {{ $players->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- MODAL (always in DOM) --}}
    <div
        x-data="{ open: @entangle('showModal').live }"
        x-cloak
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 px-4 py-6"
        role="dialog"
        aria-modal="true"
        aria-labelledby="player-modal-title"
        @keydown.escape.window="open = false; $wire.closeModal()"
    >
        <div
            x-show="open"
            x-transition.scale.origin.center
            class="relative w-full max-w-lg rounded-2xl border border-neutral-200 bg-white p-5 shadow-xl dark:border-neutral-700 dark:bg-neutral-950"
        >
            <button
                type="button"
                @click="open = false; $wire.closeModal()"
                class="absolute right-3 top-3 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300"
            >
                <flux:icon.x variant="micro"/>
            </button>

            <h3 id="player-modal-title" class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                Edit Player
            </h3>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Update data player dan bank/e-wallet.
            </p>

            <form wire:submit.prevent="save" class="mt-4 space-y-5">
                {{-- Player --}}
                <div class="grid gap-3 md:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">Username</label>
                        <input wire:model.defer="username" type="text"
                               class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                        @error('username') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">EXT Username</label>
                        <input wire:model.defer="ext_username" type="text"
                               class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                        @error('ext_username') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">Email</label>
                        <input wire:model.defer="email" type="email"
                               class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                        @error('email') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">Phone</label>
                        <input wire:model.defer="phone" type="text"
                               class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                        @error('phone') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">Upline</label>
                        <input wire:model.defer="upline" type="text"
                               class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                        @error('upline') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">KYC Status</label>
                        <select wire:model.defer="status_kyc"
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                        </select>
                        @error('status_kyc') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- BANK LIST (sub-table) --}}
                <div
                    class="space-y-3 rounded-2xl border border-neutral-200/70 bg-neutral-50/60 p-4 dark:border-neutral-800 dark:bg-neutral-900/40">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                                Bank / E-Wallet
                            </p>
                            <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                Satu player bisa punya lebih dari satu rekening / wallet.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="addBank"
                            class="inline-flex items-center gap-1 rounded-lg bg-neutral-900 px-2.5 py-1 text-xs font-medium text-white dark:bg-neutral-100 dark:text-neutral-900"
                        >
                            <flux:icon.plus variant="micro"/>
                            Add
                        </button>
                    </div>

                    @error('banks')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs border-separate border-spacing-y-1">
                            <thead class="text-neutral-500 dark:text-neutral-400">
                            <tr>
                                <th class="text-left px-2 py-1">Bank</th>
                                <th class="text-left px-2 py-1">Type</th>
                                <th class="text-left px-2 py-1">Account</th>
                                <th class="px-2 py-1"></th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($banks as $i => $bank)
                                @if(empty($bank['_delete']))
                                    <tr wire:key="player-bank-row-{{ $editing?->id ?? 'x' }}-{{ $i }}"
                                        class="rounded-lg bg-white shadow-sm dark:bg-neutral-950">
                                        <td class="px-2 py-2 align-top">
                                            <select
                                                wire:model.defer="banks.{{ $i }}.bank_name"
                                                class="w-full rounded-lg border border-neutral-200 bg-white px-2 py-1 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                                                <option value="">—</option>
                                                @foreach(self::BANK_NAMES as $bn)
                                                    <option value="{{ $bn }}">{{ $bn }}</option>
                                                @endforeach
                                            </select>
                                            @error("banks.$i.bank_name") <p
                                                class="mt-1 text-[11px] text-red-500">{{ $message }}</p> @enderror
                                        </td>

                                        <td class="px-2 py-2 align-top">
                                            <select
                                                wire:model.defer="banks.{{ $i }}.bank_type"
                                                class="w-full rounded-lg border border-neutral-200 bg-white px-2 py-1 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                                                <option value="bank">Bank</option>
                                                <option value="wallet">Wallet</option>
                                            </select>
                                            @error("banks.$i.bank_type") <p
                                                class="mt-1 text-[11px] text-red-500">{{ $message }}</p> @enderror
                                        </td>

                                        <td class="px-2 py-2 align-top">
                                            <input
                                                wire:model.defer="banks.{{ $i }}.account_number"
                                                placeholder="Number"
                                                class="w-full rounded-lg border border-neutral-200 bg-white px-2 py-1 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                                            @error("banks.$i.account_number") <p
                                                class="mt-1 text-[11px] text-red-500">{{ $message }}</p> @enderror

                                            <input
                                                wire:model.defer="banks.{{ $i }}.account_name"
                                                placeholder="Name"
                                                class="mt-1 w-full rounded-lg border border-neutral-200 bg-white px-2 py-1 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50">
                                            @error("banks.$i.account_name") <p
                                                class="mt-1 text-[11px] text-red-500">{{ $message }}</p> @enderror
                                        </td>

                                        <td class="px-2 py-2 text-right align-top">
                                            <button
                                                type="button"
                                                wire:click="removeBank({{ $i }})"
                                                class="inline-flex items-center rounded-lg p-1 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                                <flux:icon.trash variant="micro"/>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 text-center text-neutral-500 dark:text-neutral-400">
                                        Belum ada bank.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Status toggle --}}
                <div
                    class="flex items-center justify-between rounded-xl border border-neutral-200 bg-neutral-50 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="space-y-0.5">
                        <p class="text-xs font-medium text-neutral-800 dark:text-neutral-100">
                            {{ $status ? 'Active' : 'Inactive' }}
                        </p>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                            Nonaktifkan jika akun player diblokir sementara.
                        </p>
                    </div>
                    <button
                        type="button"
                        wire:click="$set('status', {{ $status ? 'false' : 'true' }})"
                        class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors duration-200 {{ $status ? 'bg-emerald-500' : 'bg-neutral-400' }}"
                    >
                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition duration-200 {{ $status ? 'translate-x-4' : 'translate-x-1' }}"></span>
                    </button>
                </div>

                <div
                    class="flex items-center justify-end gap-2 border-t border-neutral-200 pt-3 dark:border-neutral-800">
                    <button
                        type="button"
                        @click="open = false; $wire.closeModal()"
                        class="inline-flex items-center rounded-lg border border-neutral-300 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-900"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="inline-flex items-center rounded-lg bg-neutral-900 px-3.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-neutral-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200"
                    >
                        <span wire:loading.remove wire:target="save">Save Changes</span>
                        <span wire:loading.flex wire:target="save" class="items-center gap-1">
                            <span
                                class="h-3 w-3 animate-spin rounded-full border border-white border-t-transparent dark:border-neutral-900 dark:border-t-transparent"></span>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
