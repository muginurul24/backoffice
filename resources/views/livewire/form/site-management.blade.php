<section
    class="relative overflow-hidden rounded-2xl border border-neutral-200/70 bg-white/90 p-6 shadow-sm backdrop-blur-sm dark:border-neutral-700/70 dark:bg-neutral-950/90">

    <x-placeholder-pattern
        class="pointer-events-none absolute inset-0 size-full stroke-gray-900/5 dark:stroke-neutral-100/5"/>

    <div class="relative space-y-4">
        @if ($errors->any())
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800/60 dark:bg-red-950/60 dark:text-red-200">
                <div class="font-semibold">Terjadi kesalahan pada form.</div>
                <ul class="mt-1 space-y-0.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            wire:submit.prevent="handleSubmit"
            enctype="multipart/form-data"
            class="space-y-8"
        >
            {{-- BASIC INFORMATION --}}
            <div class="space-y-4">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                    Basic Information
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
                    {{-- Site Name --}}
                    <div class="space-y-1.5">
                        <label for="name" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Site Name
                        </label>
                        <input
                            id="name"
                            type="text"
                            required
                            wire:model.defer="name"
                            class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                            placeholder="Contoh: Anxiety138"
                            autocomplete="off"
                        >
                        @error('name')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Nama internal untuk identifikasi site.
                            </p>
                            @enderror
                    </div>

                    {{-- URL --}}
                    <div class="space-y-1.5">
                        <label for="url" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            URL
                        </label>
                        <input
                            id="url"
                            type="text"
                            required
                            wire:model.defer="url"
                            class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                            placeholder="https://example.com"
                            autocomplete="off"
                        >
                        @error('url')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Main URL <code>(tidak nawala)</code>.
                            </p>
                            @enderror
                    </div>
                </div>
            </div>

            {{-- LAYOUT & THEME --}}
            <div class="space-y-4">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                    Layout & Theme
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
                    {{-- Type --}}
                    <div class="space-y-1.5">
                        <label for="type" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Site Type
                        </label>
                        <select
                            id="type"
                            wire:model.live="type"
                            class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                        >
                            <option value="">Pilih type site</option>
                            @foreach($this->typeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Menentukan engine/layout utama yang akan digunakan.
                            </p>
                            @enderror
                    </div>

                    {{-- Theme --}}
                    <div class="space-y-1.5">
                        <label for="theme" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Theme
                        </label>
                        <select
                            id="theme"
                            wire:model.live="theme"
                            @disabled(! $type)
                            class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 disabled:cursor-not-allowed disabled:bg-neutral-100 disabled:text-neutral-400 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:disabled:bg-neutral-900/60 dark:disabled:text-neutral-600 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                        >
                            <option value="">{{ $type ? 'Pilih theme' : 'Pilih type terlebih dahulu' }}</option>

                            @foreach($this->themeOptions as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        @error('theme')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                @if (in_array($type, ['nexus-amb', 'nexus-siam']))
                                    Theme khusus untuk layout Nexus (kombinasi warna & style).
                                @elseif($type)
                                    Pilih salah satu dari 40 preset theme numerik untuk type {{ $type }}.
                                @else
                                    Pilih type terlebih dahulu untuk melihat daftar theme.
                                @endif
                            </p>
                            @enderror
                    </div>
                </div>
            </div>

            {{-- META & CONTENT --}}
            <div class="space-y-4">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                    Meta & Content
                </h2>

                {{-- Title --}}
                <div class="space-y-1.5">
                    <label for="title" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                        Meta Title
                    </label>
                    <input
                        id="title"
                        type="text"
                        required
                        wire:model.defer="title"
                        class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                        placeholder="Judul halaman utama untuk SEO"
                        autocomplete="off"
                    >
                    @error('title')
                    <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                    @else
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Judul yang tampil di tab browser dan hasil pencarian.
                        </p>
                        @enderror
                </div>

                {{-- Description --}}
                <div class="space-y-1.5">
                    <label for="description" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                        Meta Description
                    </label>
                    <textarea
                        id="description"
                        rows="3"
                        required
                        wire:model.defer="description"
                        class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                        placeholder="Deskripsi singkat site untuk SEO dan preview sosial."
                        autocomplete="off"
                    ></textarea>
                    @error('description')
                    <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                    @else
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Biasanya 120–160 karakter, jelaskan value utama site.
                        </p>
                        @enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    {{-- Keywords --}}
                    <div class="space-y-1.5">
                        <label for="keywords" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Keywords
                        </label>
                        <textarea
                            id="keywords"
                            rows="3"
                            wire:model.defer="keywords"
                            class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                            placeholder="slot gacor, agen rekomendasi 2025 ..."
                            autocomplete="off"
                        ></textarea>
                        @error('keywords')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Pisahkan dengan koma, digunakan untuk meta keywords.
                            </p>
                            @enderror
                    </div>

                    {{-- Marquee --}}
                    <div class="space-y-1.5">
                        <label for="marquee" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Marquee Text
                        </label>
                        <textarea
                            id="marquee"
                            rows="3"
                            wire:model.defer="marquee"
                            class="block w-full rounded-xl border border-neutral-200 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-50 dark:focus:border-neutral-100 dark:focus:ring-neutral-100/10"
                            placeholder="Teks berjalan untuk pemberitahuan/promo penting."
                            autocomplete="off"
                        ></textarea>
                        @error('marquee')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Teks yang akan tampil di marquee (running text).
                            </p>
                            @enderror
                    </div>
                </div>
            </div>

            {{-- BRAND ASSETS --}}
            <div class="space-y-4">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                    Brand Assets
                </h2>

                <div class="grid gap-4 md:grid-cols-3">
                    {{-- Logo --}}
                    <div class="space-y-1.5">
                        <label for="logo" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Logo
                        </label>
                        <input
                            id="logo"
                            type="file"
                            accept="image/*"
                            wire:model="logo"
                            class="block w-full cursor-pointer rounded-xl border border-dashed border-neutral-300 bg-white px-3 py-2.5 text-xs text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-neutral-900 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:border-neutral-400 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 dark:file:bg-neutral-100 dark:file:text-neutral-900"
                        >
                        @error('logo')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Upload logo, path akan disimpan di database.
                            </p>
                            @enderror

                            @if ($logo)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Preview baru:</p>
                                <img src="{{ $logo->temporaryUrl() }}" alt="Logo preview"
                                     class="mt-1 h-14 rounded-lg border border-neutral-200 object-contain dark:border-neutral-700">
                            @elseif($isEdit && $site?->logo)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Current:</p>
                                <img src="{{ asset('storage/'.$site->logo) }}" alt="Logo current"
                                     class="mt-1 h-14 rounded-lg border border-neutral-200 object-contain dark:border-neutral-700">
                            @endif
                    </div>

                    {{-- Favicon --}}
                    <div class="space-y-1.5">
                        <label for="favicon" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Favicon
                        </label>
                        <input
                            id="favicon"
                            type="file"
                            accept="image/*"
                            wire:model="favicon"
                            class="block w-full cursor-pointer rounded-xl border border-dashed border-neutral-300 bg-white px-3 py-2.5 text-xs text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-neutral-900 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:border-neutral-400 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 dark:file:bg-neutral-100 dark:file:text-neutral-900"
                        >
                        @error('favicon')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Icon kecil untuk tab browser (favicon).
                            </p>
                            @enderror

                            @if ($favicon)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Preview baru:</p>
                                <img src="{{ $favicon->temporaryUrl() }}" alt="Favicon preview"
                                     class="mt-1 h-8 w-8 rounded border border-neutral-200 object-contain dark:border-neutral-700">
                            @elseif($isEdit && $site?->favicon)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Current:</p>
                                <img src="{{ asset('storage/'.$site->favicon) }}" alt="Favicon current"
                                     class="mt-1 h-8 w-8 rounded border border-neutral-200 object-contain dark:border-neutral-700">
                            @endif
                    </div>

                    {{-- Social Card --}}
                    <div class="space-y-1.5">
                        <label for="card" class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                            Social Card / Preview Image
                        </label>
                        <input
                            id="card"
                            type="file"
                            accept="image/*"
                            wire:model="card"
                            class="block w-full cursor-pointer rounded-xl border border-dashed border-neutral-300 bg-white px-3 py-2.5 text-xs text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-neutral-900 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:border-neutral-400 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 dark:file:bg-neutral-100 dark:file:text-neutral-900"
                        >
                        @error('card')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Gambar untuk preview di sosial media (OG image).
                            </p>
                            @enderror

                            @if ($card)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Preview baru:</p>
                                <img src="{{ $card->temporaryUrl() }}" alt="Card preview"
                                     class="mt-1 h-20 w-full rounded-lg border border-neutral-200 object-cover dark:border-neutral-700">
                            @elseif($isEdit && $site?->card)
                                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Current:</p>
                                <img src="{{ asset('storage/'.$site->card) }}" alt="Card current"
                                     class="mt-1 h-20 w-full rounded-lg border border-neutral-200 object-cover dark:border-neutral-700">
                            @endif
                    </div>
                </div>
            </div>

            {{-- OPERATIONAL SETTINGS --}}
            <div class="space-y-4">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                    Operational Settings
                </h2>

                <div class="grid gap-4 md:grid-cols">
                    <div class="space-y-1.5">
                        <div
                            x-data="{ on: @entangle('status') }"
                            class="flex items-center justify-between rounded-xl border border-neutral-200 bg-neutral-50 px-3 py-2.5 dark:border-neutral-700 dark:bg-neutral-900"
                        >
                            <div class="space-y-0.5">
                                <p class="text-sm font-medium text-neutral-800 dark:text-neutral-100">
                                    <span x-text="on ? 'Active' : 'Inactive'"></span>
                                </p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Nonaktifkan jika site sedang maintenance atau tidak digunakan.
                                </p>
                            </div>

                            <button
                                type="button"
                                @click="on = !on"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border border-transparent transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500/50"
                                :class="on ? 'bg-emerald-500 dark:bg-emerald-500' : 'bg-neutral-300 dark:bg-neutral-700'"
                            >
                                <span
                                    class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200"
                                    :class="on ? 'translate-x-5' : 'translate-x-1'"></span>
                            </button>
                        </div>

                        @error('status')
                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div
                    class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-800/60 dark:bg-emerald-950/60 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif
            {{-- ACTIONS --}}
            <div
                class="flex items-center justify-end gap-3 border-t border-neutral-200/80 pt-4 dark:border-neutral-800">
                <a
                    href="#"
                    class="inline-flex items-center rounded-xl border border-neutral-300 px-3.5 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-900"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-neutral-900 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-neutral-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-500 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove> {{ $isEdit ? 'Save Changes' : 'Create Site' }} </span>
                    <span wire:loading class="flex items-center gap-1">
                        <span class="h-3 w-3 animate-spin rounded-full border border-white border-t-transparent"></span>
                        Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</section>
