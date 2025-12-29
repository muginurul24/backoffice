<x-layouts.app :title="__('Site Management')">
    <div class="mx-auto flex w-full max-w-5xl flex-1 flex-col gap-6 py-4">
        {{-- PAGE HEADER --}}
        <header class="flex flex-col gap-2">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">
                Site Management
            </h1>
            <p class="max-w-2xl text-sm text-neutral-500 dark:text-neutral-400">
                Kelola informasi utama website, meta SEO, aset brand, dan pengaturan status operasional.
            </p>
        </header>

        {{-- MAIN CARD --}}
        <livewire:form.site-management/>
    </div>
</x-layouts.app>
