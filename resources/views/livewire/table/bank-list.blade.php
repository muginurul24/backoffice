<div>
    <section
        class="relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:bg-neutral-950/90">

        <x-placeholder-pattern
            class="pointer-events-none absolute inset-0 size-full stroke-gray-900/5 dark:stroke-neutral-100/5"/>

        <div class="relative space-y-4">
            {{-- HEADER + FILTERS --}}
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-neutral-600 dark:text-neutral-400">
                        Payment Channels
                    </h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-500">
                        Daftar semua metode pembayaran yang terhubung dengan site ini.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                    {{-- Search --}}
                    <div class="relative sm:min-w-[220px]">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search..."
                            class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                        >
                        <span
                            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-neutral-400">
                            <flux:icon.search variant="micro"/>
                        </span>
                    </div>

                    {{-- Filter type --}}
                    <select
                        wire:model.live="bankTypeFilter"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                        @foreach($this->bankTypeOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    {{-- Add Payment Channel --}}
                    <button
                        type="button"
                        wire:click="create"
                        class="inline-flex items-center justify-center rounded-xl bg-neutral-900 px-3.5 py-2 text-xs font-medium text-white shadow-sm hover:bg-neutral-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200"
                    >
                        <flux:icon.plus variant="micro" class="mr-1.5"/>
                        Add
                    </button>
                </div>
            </div>

            {{-- SUCCESS ALERT --}}
            @if (session('success'))
                <div
                    class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-xs text-emerald-800 dark:border-emerald-800/60 dark:bg-emerald-950/60 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- TABLE CARD --}}
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
                                Method
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Type
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Account
                            </th>
                            <th class="px-4 py-2.5 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Status
                            </th>
                            <th class="px-4 py-2.5 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400">
                                Actions
                            </th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-neutral-200/80 dark:divide-neutral-800">
                        @forelse($payments as $key => $payment)
                            <tr wire:key="payment-row-{{ $payment->id }}"
                                class="hover:bg-neutral-50/80 dark:hover:bg-neutral-900/60">
                                {{-- Method --}}
                                <td class="px-4 py-2.5 align-center">
                                    <span
                                        class="text-xs font-medium text-neutral-900 dark:text-neutral-50">{{ $key + 1 }}</span>
                                </td>
                                <td class="px-4 py-2.5 align-center">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-neutral-900 dark:text-neutral-50">
                                            {{ $payment->bank_name }}
                                        </span>
                                        <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                            ID: {{ $payment->id }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Type --}}
                                <td class="px-4 py-2.5 align-center">
                                    @php
                                        $typeLabel = $typeLabels[$payment->bank_type] ?? strtoupper($payment->bank_type);
                                    @endphp
                                    <span
                                        class="inline-flex items-center rounded-full bg-neutral-100 px-2 py-0.5 text-[11px] font-medium text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">
                                        {{ $typeLabel }}
                                    </span>
                                </td>

                                {{-- Account --}}
                                <td class="px-4 py-2.5 align-center">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-neutral-900 dark:text-neutral-50">
                                            {{ $payment->account_number }}
                                        </span>
                                        <span class="text-[11px] text-neutral-500 dark:text-neutral-400">
                                            {{ $payment->account_name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Status (INLINE TOGGLE) --}}
                                <td class="px-4 py-2.5 align-center">
                                    <button
                                        type="button"
                                        wire:click="toggleStatus({{ $payment->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="toggleStatus({{ $payment->id }})"
                                        class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium
                                            {{ $payment->status
                                                ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200'
                                                : 'bg-red-50 text-red-700 dark:bg-red-900/40 dark:text-red-200' }}"
                                    >
                                        <span
                                            class="mr-1 h-1.5 w-1.5 rounded-full {{ $payment->status ? 'bg-emerald-500' : 'bg-red-500' }}">
                                        </span>
                                        {{ $payment->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-2.5 align-center text-right">
                                    <button
                                        type="button"
                                        wire:click="edit({{ $payment->id }})"
                                        class="inline-flex items-center rounded-lg border border-neutral-300 px-2.5 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-900"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-4 py-6 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                    Belum ada payment channel untuk site ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($payments->hasPages())
                    <div
                        class="border-t border-neutral-200/80 bg-neutral-50/80 px-4 py-2.5 text-xs text-neutral-500 dark:border-neutral-800 dark:bg-neutral-900/80 dark:text-neutral-400">
                        {{ $payments->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- MODAL: CREATE / EDIT (SELALU ADA DI DOM) --}}
    <div
        x-data="{ open: @entangle('showEditModal').live }"
        x-cloak
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 px-4 py-6"
        role="dialog"
        aria-modal="true"
        aria-labelledby="payment-modal-title"
        @keydown.escape.window="open = false; $wire.closeModal()"
    >
        <div
            x-show="open"
            x-transition.scale.origin.center
            class="relative w-full max-w-md rounded-2xl border border-neutral-200 bg-white p-5 shadow-xl dark:border-neutral-700 dark:bg-neutral-950">

            {{-- Close button --}}
            <button
                type="button"
                @click="open = false; $wire.closeModal()"
                class="absolute right-3 top-3 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300"
            >
                <flux:icon.x variant="micro"/>
            </button>

            <h3
                id="payment-modal-title"
                class="text-sm font-semibold text-neutral-900 dark:text-neutral-50"
            >
                {{ $editing ? 'Edit Payment Channel' : 'Add Payment Channel' }}
            </h3>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                {{ $editing
                    ? 'Update informasi channel pembayaran yang sudah ada.'
                    : 'Tambahkan channel pembayaran baru untuk site ini.' }}
            </p>

            <form wire:submit.prevent="savePayment" class="mt-4 space-y-4 text-sm">
                {{-- Bank / Channel --}}
                <div class="space-y-1">
                    <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">
                        Bank / Channel
                    </label>
                    <select
                        wire:model.defer="bank_name"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                        <option value="">Pilih bank / channel</option>

                        <optgroup label="QRIS">
                            <option value="QRIS">QRIS</option>
                        </optgroup>

                        <optgroup label="Pulsa">
                            <option value="TELKOMSEL">TELKOMSEL</option>
                            <option value="XL">XL</option>
                        </optgroup>

                        <optgroup label="Crypto">
                            <option value="BTC">BTC</option>
                            <option value="USDT">USDT</option>
                            <option value="BNB">BNB</option>
                            <option value="SOL">SOL</option>
                            <option value="XRP">XRP</option>
                        </optgroup>

                        <optgroup label="Bank Transfer">
                            <option value="BCA">BCA</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="BSI">BSI</option>
                            <option value="CIMB">CIMB</option>
                            <option value="MANDIRI">MANDIRI</option>
                            <option value="PERMATA">PERMATA</option>
                            <option value="JAGO">JAGO</option>
                            <option value="SEABANK">SEABANK</option>
                            <option value="NEOBANK">NEOBANK</option>
                        </optgroup>

                        <optgroup label="E-Wallet">
                            <option value="DANA">DANA</option>
                            <option value="OVO">OVO</option>
                            <option value="GOPAY">GOPAY</option>
                            <option value="LINKAJA">LINKAJA</option>
                            <option value="SAKUKU">SAKUKU</option>
                            <option value="SHOPEEPAY">SHOPEEPAY</option>
                        </optgroup>
                    </select>
                    @error('bank_name')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Channel Type --}}
                <div class="space-y-1">
                    <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">
                        Channel Type
                    </label>
                    <select
                        wire:model.defer="bank_type"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                        <option value="">Pilih type</option>
                        <option value="qris">QRIS</option>
                        <option value="pulsa">Pulsa</option>
                        <option value="crypto">Crypto</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="wallet">E-Wallet</option>
                    </select>
                    @error('bank_type')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Account Number --}}
                <div class="space-y-1">
                    <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">
                        Account Number
                    </label>
                    <input
                        type="text"
                        wire:model.defer="account_number"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                    @error('account_number')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Account Name --}}
                <div class="space-y-1">
                    <label class="text-xs font-medium text-neutral-700 dark:text-neutral-200">
                        Account Name
                    </label>
                    <input
                        type="text"
                        wire:model.defer="account_name"
                        class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-xs text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                    >
                    @error('account_name')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status toggle --}}
                <div
                    class="flex items-center justify-between rounded-xl border border-neutral-200 bg-neutral-50 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="space-y-0.5">
                        <p class="text-xs font-medium text-neutral-800 dark:text-neutral-100">
                            {{ $status ? 'Active' : 'Inactive' }}
                        </p>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400">
                            Nonaktifkan jika channel sedang tidak dapat digunakan.
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

                {{-- ACTION BUTTONS --}}
                <div
                    class="mt-3 flex items-center justify-end gap-2 border-t border-neutral-200 pt-3 dark:border-neutral-800">
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
                        wire:target="savePayment"
                        class="inline-flex items-center rounded-lg bg-neutral-900 px-3.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-neutral-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200"
                    >
                        <span wire:loading.remove wire:target="savePayment">
                            {{ $editing ? 'Save Changes' : 'Create Channel' }}
                        </span>
                        <span wire:loading.flex wire:target="savePayment" class="items-center gap-1">
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
