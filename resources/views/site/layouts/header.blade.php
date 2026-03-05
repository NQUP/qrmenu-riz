        <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/80 backdrop-blur">
            <div class="w-full px-4 py-4 md:px-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-teal-600 to-amber-400 shadow-lg"></div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-semibold tracking-wide">{{ siteSetting('site_name') }}</h1>
                        <p class="text-xs text-slate-500">Menu digital modern</p>
                    </div>
                </div>
                <a
                    class="hidden sm:inline-flex items-center justify-center rounded-full bg-slate-900 text-white px-5 py-2 text-sm tracking-wide hover:bg-slate-800 transition-colors duration-300"
                    href="{{ route('orders.create') }}"
                >
                    Pesan Sekarang
                </a>
            </div>
        </header>
        <section class="relative">
            <div class="w-full px-4 md:px-6 pt-12 pb-10 md:pt-16 md:pb-14">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-7">
                        <span class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.3em] text-teal-700 bg-teal-50 px-3 py-1 rounded-full">
                            Menu Harian
                        </span>
                        <h2 class="mt-5 text-4xl md:text-5xl font-semibold leading-tight text-slate-900">
                            Selamat Datang
                        </h2>
                        <p class="mt-4 text-slate-600 text-lg leading-relaxed">
                            Temukan harmoni sempurna antara kenyamanan dan <span class="text-amber-600 font-semibold">kelezatan</span>.
                        </p>
                        <div class="mt-7 flex flex-wrap gap-3">
                            <a
                                class="inline-flex items-center justify-center rounded-full bg-slate-900 text-white px-6 py-3 text-sm tracking-wide hover:bg-slate-800 transition-colors duration-300"
                                href="{{ route('orders.create') }}"
                            >
                                Pesan Sekarang
                            </a>
                            <a
                                class="inline-flex items-center justify-center rounded-full border border-slate-300 text-slate-700 px-6 py-3 text-sm tracking-wide hover:border-slate-400 hover:text-slate-900 transition-colors duration-300"
                                href="#produk"
                            >
                                Lihat Menu
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-5">
                        <div class="rounded-3xl bg-white shadow-xl border border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-slate-500">Rekomendasi Hari Ini</p>
                                    <p class="text-xl font-semibold text-slate-900">Pilihan Terlaris</p>
                                </div>
                                <span class="material-symbols-outlined text-3xl text-amber-500">restaurant_menu</span>
                            </div>
                            <div class="mt-6 space-y-3 text-sm text-slate-600">
                                <div class="flex items-center justify-between">
                                    <span>Menu Makanan Premium</span>
                                    <span class="font-semibold text-slate-900">Baru</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Menu Musiman</span>
                                    <span class="font-semibold text-slate-900">Favorit</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Paket Hemat</span>
                                    <span class="font-semibold text-slate-900">Harian</span>
                                </div>
                            </div>
                            @php
                                $orderUrl = url('/pesan');
                            @endphp
                            <div class="mt-6 flex items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="h-24 w-24 rounded-lg border border-slate-200 bg-white p-2">
                                    {!! QrCode::size(96)->margin(0)->generate($orderUrl) !!}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Scan untuk Pesan</p>
                                    <p class="text-xs text-slate-500 break-all">{{ $orderUrl }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <nav class="sticky top-16 z-40 bg-white/90 backdrop-blur border-y border-slate-200/70">
            <div class="w-full px-4 py-4 md:px-6">
                <div class="flex overflow-x-auto gap-3 pb-2 no-scrollbar">
                    <button
                        class="category-btn bg-slate-900 text-white px-5 py-2 rounded-full shadow-sm whitespace-nowrap hover:bg-slate-800 transition-all duration-300 text-sm"
                        data-category="all">
                        Semua
                    </button>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <button
                                class="category-btn bg-white text-slate-700 px-5 py-2 rounded-full shadow-sm whitespace-nowrap hover:bg-slate-100 transition-all duration-300 border border-slate-200 text-sm"
                                data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>
        </nav>
