<x-layouts.app :title="__('Users')">
    <div class="mx-auto flex w-full max-w-6xl flex-1 flex-col gap-6 py-4">
        <header class="flex flex-col gap-2">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                Users / Players
            </h1>
            <p class="max-w-3xl text-sm text-neutral-500 dark:text-neutral-400">
                Kelola data player, status KYC, status akun, dan informasi bank / e-wallet.
            </p>
        </header>

        <livewire:table.user/>
    </div>
</x-layouts.app>
