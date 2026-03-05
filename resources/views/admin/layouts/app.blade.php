<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    @php($settings = $settings ?? \App\Models\SiteSetting::getCached())
    <link rel="icon" type="image/png"
        href="{{ !empty($settings?->site_favicon) ? asset('storage/' . $settings->site_favicon) : asset('images/logo.png') }}">
    <script>
        (() => {
            const storedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <style>
        :root {
            --admin-bg: #f8fafc;
            --admin-bg-glow-top: rgba(37, 99, 235, 0.14);
            --admin-bg-glow-bottom: rgba(79, 70, 229, 0.11);
            --admin-surface: #ffffff;
            --admin-surface-soft: #f8fafc;
            --admin-border: #dbe4ee;
            --admin-text: #0f172a;
            --admin-text-soft: #475569;
        }

        .dark:root {
            --admin-bg: #020617;
            --admin-bg-glow-top: rgba(56, 189, 248, 0.2);
            --admin-bg-glow-bottom: rgba(99, 102, 241, 0.16);
            --admin-surface: #0f172a;
            --admin-surface-soft: #111d34;
            --admin-border: #253347;
            --admin-text: #e2e8f0;
            --admin-text-soft: #94a3b8;
        }

        .admin-shell {
            font-size: 18px;
            line-height: 1.7;
            color: var(--admin-text);
        }

        .admin-shell .text-xs {
            font-size: 0.98rem !important;
            line-height: 1.45rem !important;
        }

        .admin-shell .text-sm {
            font-size: 1.08rem !important;
            line-height: 1.7rem !important;
        }

        .admin-shell :is(p, li, td, th, label, a, button, input, select, textarea) {
            font-size: 1.02rem;
        }

        .admin-shell h1 {
            font-size: clamp(2rem, 3vw, 2.8rem) !important;
        }

        .admin-shell h2 {
            font-size: clamp(1.45rem, 2vw, 2rem) !important;
        }

        .admin-surface {
            background: var(--admin-surface);
            border-color: var(--admin-border);
            box-shadow: 0 12px 28px -20px rgba(15, 23, 42, 0.4);
        }

        .admin-header {
            background: color-mix(in srgb, var(--admin-surface) 90%, var(--admin-surface-soft) 10%);
            border-color: var(--admin-border);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-shell bg-slate-50 text-slate-900 selection:bg-sky-200 selection:text-slate-900 dark:bg-slate-950 dark:text-slate-100 dark:selection:bg-indigo-800 dark:selection:text-slate-100">
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0 -z-10" style="background:
            radial-gradient(circle at top, var(--admin-bg-glow-top), transparent 36%),
            radial-gradient(circle at bottom, var(--admin-bg-glow-bottom), transparent 45%),
            linear-gradient(to bottom, var(--admin-bg), var(--admin-bg));"></div>

        <header class="admin-header sticky top-0 z-30 border-b">
            <div class="flex w-full items-center justify-between px-4 py-4 md:px-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-sky-700 to-indigo-600 text-sm font-bold text-white shadow-md">QR</span>
                    <span>
                        <span class="block text-sm font-semibold text-slate-900 dark:text-slate-100">QR Menu Admin</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400">Control center</span>
                    </span>
                </a>
                <div class="flex items-center gap-2">
                    <button type="button" id="theme-toggle" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700" aria-label="Ubah mode tema">
                        <i class="fa fa-sun-o text-lg dark:hidden" aria-hidden="true"></i>
                        <i class="fa fa-moon-o hidden text-lg dark:block" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('front.home') }}" class="rounded-lg border border-sky-200 bg-gradient-to-r from-sky-50 to-indigo-50 px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:from-sky-100 hover:to-indigo-100 dark:border-sky-800 dark:from-slate-800 dark:to-slate-700 dark:text-slate-100 dark:hover:from-slate-700 dark:hover:to-slate-600">
                        Lihat Situs
                    </a>
                </div>
            </div>
        </header>

        <div class="grid w-full grid-cols-1 gap-6 px-4 py-6 md:grid-cols-12 md:px-8">
            <aside class="md:col-span-3 xl:col-span-2">
                <div class="sticky top-24 space-y-4">
                    <nav class="admin-surface overflow-hidden rounded-2xl border">
                        <div class="bg-gradient-to-br from-sky-800 via-blue-700 to-indigo-700 p-4 text-white">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-300 text-center">Dashboard Menu</p>
                            <p class="mt-2 text-sm font-semibold text-center">Navigasi Admin</p>
                            <p class="mt-1 text-xs text-slate-300 text-center">Kelola konten, transaksi, dan pengaturan.</p>
                        </div>

                        <div class="space-y-1 p-3 text-sm">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-sky-700 to-indigo-600 font-medium text-white shadow-sm' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-sky-300' }}">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/15' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                    <i class="fa fa-dashboard" aria-hidden="true"></i>
                                </span>
                                Dashboard
                            </a>

                            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-sky-700 to-indigo-600 font-medium text-white shadow-sm' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-sky-300' }}">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white/15' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                                </span>
                                Produk
                            </a>

                            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-sky-700 to-indigo-600 font-medium text-white shadow-sm' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-sky-300' }}">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white/15' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                    <i class="fa fa-th-large" aria-hidden="true"></i>
                                </span>
                                Kategori
                            </a>

                            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-sky-700 to-indigo-600 font-medium text-white shadow-sm' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-sky-300' }}">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-white/15' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                </span>
                                Pesanan
                            </a>

                            <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-sky-700 to-indigo-600 font-medium text-white shadow-sm' : 'text-slate-700 hover:bg-sky-50 hover:text-sky-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-sky-300' }}">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/15' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                </span>
                                Pengaturan
                            </a>
                        </div>
                    </nav>

                    <!-- <div class="rounded-2xl border border-teal-100/80 bg-gradient-to-br from-teal-50/90 to-cyan-50/90 p-4 shadow-sm backdrop-blur dark:border-slate-800 dark:from-slate-900 dark:to-slate-800">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Catatan</p>
                        <p class="mt-2 text-sm font-medium text-slate-800 dark:text-slate-100">Sidebar baru aktif</p>
                        <p class="mt-1 text-xs leading-relaxed text-slate-500 dark:text-slate-400">Gaya visual disamakan dengan halaman depan: premium, hangat, dan lebih berkarakter.</p>
                    </div> -->

                    @yield('sidebar')
                </div>
            </aside>

            <main class="md:col-span-9 xl:col-span-10">
                @if (session('success'))
                <div class="mb-4 rounded-xl border border-emerald-200/90 bg-emerald-50/90 px-4 py-3 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/80 dark:bg-emerald-950/45 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 rounded-xl border border-rose-200/90 bg-rose-50/90 px-4 py-3 text-sm text-rose-800 shadow-sm dark:border-rose-900/80 dark:bg-rose-950/45 dark:text-rose-200">
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200/90 bg-rose-50/90 px-4 py-3 text-sm text-rose-800 shadow-sm dark:border-rose-900/80 dark:bg-rose-950/45 dark:text-rose-200">
                    <p class="font-semibold">Terdapat kesalahan input:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script>
        (() => {
            const toggle = document.getElementById('theme-toggle');
            if (!toggle) return;
            toggle.addEventListener('click', () => {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                window.dispatchEvent(new CustomEvent('theme-changed', {
                    detail: {
                        isDark
                    }
                }));
            });
        })();
    </script>
    @yield('scripts')
</body>

</html>
