<x-layouts.app :title="__('Bank Management')">
    <div class="mx-auto flex w-full max-w-5xl flex-1 flex-col gap-6 py-4">
        {{-- PAGE HEADER --}}
        <header class="flex flex-col gap-2">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                Payment & Bank Management
            </h1>
            <p class="max-w-2xl text-sm text-neutral-500 dark:text-neutral-400">
                Kelola channel pembayaran (bank, e-wallet, crypto, pulsa, dan QRIS) yang terhubung dengan site ini.
            </p>
        </header>

        {{-- TABLE PAYMENT CHANNELS --}}
        <livewire:table.bank-list/>
    </div>
</x-layouts.app>
