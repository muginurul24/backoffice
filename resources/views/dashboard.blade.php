<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-2xl">
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article
                class="group relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-gradient-to-b from-white/80 to-neutral-50/90 p-4 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:from-neutral-900/80 dark:to-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                            Deposit Today
                        </p>
                        <p class="mt-2 text-2xl font-semibold tabular-nums text-neutral-900 dark:text-neutral-50">
                            Rp {{ number_format($depositToday ?? 0) }}
                        </p>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            Total deposit yang masuk hari ini
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 shadow-inner dark:bg-emerald-500/10 dark:text-emerald-300">
                        <flux:icon.circle-dollar-sign/>
                    </div>
                </div>

                <div
                    class="pointer-events-none absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-emerald-50/60 via-transparent dark:from-emerald-500/5">
                </div>
            </article>
            <article
                class="group relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-gradient-to-b from-white/80 to-neutral-50/90 p-4 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:from-neutral-900/80 dark:to-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                            Ticket Today
                        </p>
                        <p class="mt-2 text-2xl font-semibold tabular-nums text-neutral-900 dark:text-neutral-50">
                            {{ number_format($ticketToday ?? 0) }}
                        </p>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            Total ticket yang masuk hari ini
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-700 shadow-inner dark:bg-sky-500/10 dark:text-sky-300">
                        <flux:icon.ticket/>
                    </div>
                </div>
                <div
                    class="pointer-events-none absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-sky-50/60 via-transparent dark:from-sky-500/5">
                </div>
            </article>
            <article
                class="group relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-gradient-to-b from-white/80 to-neutral-50/90 p-4 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:from-neutral-900/80 dark:to-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                            Deposit Annually
                        </p>
                        <p class="mt-2 text-2xl font-semibold tabular-nums text-neutral-900 dark:text-neutral-50">
                            Rp {{ number_format($depositAnnually ?? 0) }}
                        </p>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            Akumulasi deposit keseluruhan
                        </p>
                    </div>
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700 shadow-inner dark:bg-amber-500/10 dark:text-amber-300">
                        <flux:icon.piggy-bank/>
                    </div>
                </div>
                <div
                    class="pointer-events-none absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-amber-50/60 via-transparent dark:from-amber-500/5">
                </div>
            </article>
            <article
                class="group relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-gradient-to-b from-white/80 to-neutral-50/90 p-4 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:from-neutral-900/80 dark:to-neutral-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                            Coin Balance
                        </p>
                        <p class="mt-2 text-2xl font-semibold tabular-nums text-neutral-900 dark:text-neutral-50">
                            {{ number_format($coinBalance ?? 0) }}
                        </p>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            Total coin aktif saat ini
                        </p>
                    </div>
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-700 shadow-inner dark:bg-violet-500/10 dark:text-violet-300">
                        <flux:icon.coins/>
                    </div>
                </div>
                <div
                    class="pointer-events-none absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-violet-50/60 via-transparent dark:from-violet-500/5">
                </div>
            </article>
        </section>
        <section
            class="relative h-full flex-1 overflow-hidden rounded-2xl border border-neutral-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-neutral-700/80 dark:bg-neutral-950/90">
            <x-placeholder-pattern
                class="pointer-events-none absolute inset-0 size-full stroke-gray-900/5 dark:stroke-neutral-100/5"/>
            <div class="relative flex h-full flex-col">
                <header
                    class="flex items-center justify-between gap-3 border-b border-neutral-200/80 px-4 py-3.5 text-sm dark:border-neutral-800">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                            Deposit Approved Today
                        </h2>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Riwayat deposit yang sudah disetujui pada hari ini
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span
                            class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                            Approved only
                        </span>
                    </div>
                </header>
                <div class="relative flex-1 overflow-auto">
                    <table class="min-w-full border-separate border-spacing-0 text-sm">
                        <thead
                            class="bg-neutral-50/80 text-xs uppercase tracking-wide text-neutral-500 dark:bg-neutral-900/80 dark:text-neutral-400">
                        <tr>
                            <th class="sticky top-0 z-[1] border-b border-neutral-200/80 px-4 py-2 text-left dark:border-neutral-800">
                                #
                            </th>
                            <th class="sticky top-0 z-[1] border-b border-neutral-200/80 px-4 py-2 text-left dark:border-neutral-800">
                                User
                            </th>
                            <th class="sticky top-0 z-[1] border-b border-neutral-200/80 px-4 py-2 text-left dark:border-neutral-800">
                                Amount
                            </th>
                            <th class="sticky top-0 z-[1] border-b border-neutral-200/80 px-4 py-2 text-left dark:border-neutral-800">
                                Payment Method
                            </th>
                            <th class="sticky top-0 z-[1] border-b border-neutral-200/80 px-4 py-2 text-left dark:border-neutral-800">
                                Approved At
                            </th>
                            <th class="sticky top-0 z-[1] border-b border-neutral-200/80 px-4 py-2 text-right dark:border-neutral-800">
                                Status
                            </th>
                        </tr>
                        </thead>
                        <tbody class="align-middle text-sm text-neutral-800 dark:text-neutral-100">
                        @forelse ($historyApprovedToday ?? [] as $key => $row)
                            <tr class="border-b border-neutral-100/80 odd:bg-white/60 even:bg-neutral-50/40 hover:bg-emerald-50/40 dark:border-neutral-800/80 dark:odd:bg-neutral-950/60 dark:even:bg-neutral-900/60 dark:hover:bg-emerald-500/5 transition-colors">
                                <td class="px-4 py-2.5">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $key + 1 }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $row->user->name ?? '-' }}</span>
                                        @if (!empty($row->user->email))
                                            <span
                                                class="text-xs text-neutral-500 dark:text-neutral-400">{{ $row->user->email }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                        <span class="tabular-nums font-medium">
                                            Rp {{ number_format($row->amount ?? 0) }}
                                        </span>
                                </td>
                                <td class="px-4 py-2.5">
                                        <span
                                            class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-medium text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">
                                            {{ $row->payment_method ?? '-' }}
                                        </span>
                                </td>
                                <td class="px-4 py-2.5">
                                    @if (!empty($row->approved_at))
                                        <span class="block text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ $row->approved_at->format('d M Y') }}
                                            </span>
                                        <span class="block text-xs tabular-nums">
                                                {{ $row->approved_at->format('H:i') }}
                                            </span>
                                    @else
                                        <span class="text-xs text-neutral-500">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 text-right">
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                            <span
                                                class="h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                                            Approved
                                        </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                    Belum ada deposit yang disetujui hari ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
