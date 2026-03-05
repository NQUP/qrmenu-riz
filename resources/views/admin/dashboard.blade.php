@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-sky-100/80 bg-gradient-to-r from-white via-sky-50/55 to-indigo-50/55 p-5 shadow-sm dark:border-slate-800 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 md:p-7">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Overview</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900 dark:text-slate-100 md:text-3xl">Dashboard Admin</h1>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pantau performa katalog dan aktivitas panel dalam satu tempat.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.products.create') }}" class="rounded-full bg-gradient-to-r from-sky-700 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-sm transition hover:brightness-105">
                        Tambah Produk
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-sky-200 bg-gradient-to-r from-sky-50 to-indigo-50 px-5 py-2 text-sm font-medium text-slate-700 transition hover:from-sky-100 hover:to-indigo-100">
                        Lihat Pesanan
                    </a>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-5 dark:border-emerald-900 dark:bg-emerald-950/40">
                    <p class="text-xs font-medium uppercase tracking-[0.15em] text-emerald-600">Total Produk Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $totalProducts }}</p>
                </div>
                <div class="rounded-xl border border-amber-100 bg-amber-50/70 p-5 dark:border-amber-900 dark:bg-amber-950/40">
                    <p class="text-xs font-medium uppercase tracking-[0.15em] text-amber-600">Kategori Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-amber-700">{{ $totalCategories }}</p>
                </div>
                <div class="rounded-xl border border-blue-100 bg-blue-50/70 p-5 dark:border-blue-900 dark:bg-blue-950/40">
                    <p class="text-xs font-medium uppercase tracking-[0.15em] text-blue-600">Pendapatan Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-blue-700">Rp {{ number_format((float) $totalRevenueToday, 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-blue-700/80">{{ $totalCompletedOrdersToday }} pesanan selesai hari ini</p>
                </div>
            </div>
        </div>

        <!-- <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
            <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-teal-100/80 bg-gradient-to-br from-white to-teal-50/45 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-300 hover:shadow dark:border-slate-800 dark:from-slate-900 dark:to-slate-800">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Kelola Produk</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">CRUD, filter, dan status aktif.</p>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-amber-100/80 bg-gradient-to-br from-white to-cyan-50/40 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow dark:border-slate-800 dark:from-slate-900 dark:to-slate-800">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Kelola Kategori</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Warna, ikon, urutan, aktif/nonaktif.</p>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="rounded-xl border border-violet-100/80 bg-gradient-to-br from-white to-violet-50/35 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-violet-300 hover:shadow dark:border-slate-800 dark:from-slate-900 dark:to-slate-800">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Kelola Pesanan</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Status, konfirmasi WA, hapus.</p>
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="rounded-xl border border-amber-100/80 bg-gradient-to-br from-white to-cyan-50/40 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow dark:border-slate-800 dark:from-slate-900 dark:to-slate-800">
                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Pengaturan Situs</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Logo, kontak, sosial media.</p>
            </a>
        </div> -->

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
            <div class="rounded-xl border border-teal-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100 text-center">Pendapatan Harian</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 text-center">Tren pendapatan pesanan selesai dalam 30 hari terakhir.</p>
                <div class="mt-4 h-72 w-full rounded-xl border border-sky-100/70 bg-gradient-to-br from-sky-50/60 to-indigo-50/60 p-3 dark:border-slate-700 dark:from-slate-800 dark:to-slate-800">
                    <canvas id="revenueTrendChart" class="h-full w-full" aria-label="Grafik tren pendapatan harian" role="img"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-amber-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100 text-center">Distribusi Kategori</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 text-center">Jumlah produk aktif di masing-masing kategori.</p>
                <div class="mt-4 h-64 w-full rounded-xl border border-amber-100/70 bg-gradient-to-br from-amber-50/60 to-teal-50/60 p-3 dark:border-slate-700 dark:from-slate-800 dark:to-slate-800">
                    <div id="categoryDistributionChart" class="h-full w-full" aria-label="Grafik distribusi kategori" role="img"></div>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($categoryLabels as $index => $label)
                        @php
                            $totalCategoryProducts = array_sum($categoryValues);
                            $value = $categoryValues[$index] ?? 0;
                            $percentage = $totalCategoryProducts > 0 ? ($value / $totalCategoryProducts) * 100 : 0;
                        @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $label }}</span>
                                <span class="text-slate-500 dark:text-slate-400">{{ $value }} produk</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-700">
                                <div class="h-2 rounded-full" style="width: {{ max(4, $percentage) }}%; background-color: {{ $categoryColors[$index] ?? '#334155' }}"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada kategori aktif.</p>
                    @endforelse
                </div>
            </div>
            <div class="rounded-xl border border-amber-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-slate-100 text-center">Produk Terbaru</h2>
                <div class="space-y-2 text-sm">
                    @forelse ($latestProducts->take(6) as $product)
                        <div class="rounded-lg bg-gradient-to-r from-slate-50 to-teal-50/50 px-3 py-2 dark:from-slate-800 dark:to-slate-800">
                            <p class="font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}</p>
                            <div class="mt-1 flex items-center justify-between text-xs">
                                <span class="text-slate-500 dark:text-slate-400">{{ $product->category?->name ?? '-' }}</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-300">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 dark:text-slate-400">Belum ada produk aktif.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        (() => {
            const dateLabels = @json($dateLabels);
            const dateValues = @json($dateValues);
            const categoryLabels = @json($categoryLabels);
            const categoryValues = @json($categoryValues);
            const categoryColors = @json($categoryColors);
            const rupiah = new Intl.NumberFormat('id-ID');
            const dpr = Math.max(1, Math.min(2, window.devicePixelRatio || 1));
            let trendChartInstance = null;
            let sidebarChartInstance = null;
            let categoryChartInstance = null;
            let resizeDebounce = null;
            const snapContainerToWholePixel = (element) => {
                if (!element) return;
                const rect = element.getBoundingClientRect();
                const snappedWidth = Math.max(1, Math.round(rect.width));
                const snappedHeight = Math.max(1, Math.round(rect.height));
                element.style.width = `${snappedWidth}px`;
                element.style.height = `${snappedHeight}px`;
            };

            const rerenderWithDebounce = () => {
                window.clearTimeout(resizeDebounce);
                resizeDebounce = window.setTimeout(renderDashboardCharts, 120);
            };

            const renderDashboardCharts = () => {
                const isDark = document.documentElement.classList.contains('dark');
                const axisColor = isDark ? '#94a3b8' : '#0f766e';
                const gridColor = isDark ? 'rgba(148, 163, 184, 0.16)' : 'rgba(20, 184, 166, 0.16)';
                const theme = isDark ? 'dark2' : 'light1';

                const trendCtx = document.getElementById('revenueTrendChart');
                if (trendChartInstance) {
                    trendChartInstance.destroy();
                    trendChartInstance = null;
                }

                if (trendCtx && window.Chart) {
                    const maxTicks = 8;
                    const step = Math.max(1, Math.ceil(dateLabels.length / maxTicks));

                    trendChartInstance = new Chart(trendCtx, {
                        type: 'bar',
                        data: {
                            labels: dateLabels,
                            datasets: [{
                                data: dateValues.map((value) => Number(value ?? 0)),
                                backgroundColor: isDark ? 'rgba(56, 189, 248, 0.9)' : 'rgba(37, 99, 235, 0.9)',
                                borderRadius: 6,
                                borderSkipped: false,
                                maxBarThickness: 22,
                            }],
                        },
                        options: {
                            devicePixelRatio: dpr,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: (context) => `Rp ${rupiah.format(context.parsed.y || 0)}`,
                                    },
                                },
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: isDark ? '#cbd5e1' : '#334155',
                                        maxRotation: 0,
                                        autoSkip: false,
                                        callback: (_, index) => (index % step === 0 ? dateLabels[index] : ''),
                                    },
                                    grid: { display: false },
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: isDark ? '#cbd5e1' : '#334155',
                                        callback: (value) => `Rp ${rupiah.format(Number(value) || 0)}`,
                                    },
                                    grid: { color: isDark ? '#334155' : '#e2e8f0' },
                                },
                            },
                        },
                    });
                }

                const categoryContainer = document.getElementById('categoryDistributionChart');
                if (categoryContainer && window.CanvasJS) {
                    snapContainerToWholePixel(categoryContainer);
                    const fallbackColors = ['#0d9488', '#14b8a6', '#f59e0b', '#f97316', '#6366f1'];
                    if (categoryChartInstance) {
                        categoryChartInstance.destroy();
                        categoryChartInstance = null;
                    }

                    categoryChartInstance = new CanvasJS.Chart('categoryDistributionChart', {
                    animationEnabled: true,
                    backgroundColor: 'transparent',
                    title: {
                        text: '',
                    },
                    legend: {
                        horizontalAlign: 'center',
                        verticalAlign: 'bottom',
                        fontColor: isDark ? '#cbd5e1' : '#0f172a',
                        fontSize: 13,
                    },
                    data: [{
                        type: 'doughnut',
                        startAngle: 60,
                        innerRadius: 62,
                        indexLabelPlacement: 'outside',
                        indexLabelFontSize: 14,
                        indexLabelFontWeight: '600',
                        indexLabelFontColor: isDark ? '#e2e8f0' : '#0f172a',
                        indexLabelLineColor: isDark ? '#cbd5e1' : '#334155',
                        indexLabelBackgroundColor: isDark ? 'rgba(15, 23, 42, 0.88)' : 'rgba(255, 255, 255, 0.96)',
                        indexLabel: '{label} - #percent%',
                        toolTipContent: '<b>{label}:</b> {y} (#percent%)',
                        dataPoints: categoryLabels.map((label, index) => ({
                            y: categoryValues[index] ?? 0,
                            label,
                            color: categoryColors[index] ?? fallbackColors[index % fallbackColors.length],
                        })),
                    }],
                });
                    categoryChartInstance.render();
                }

                const sidebarCtx = document.getElementById('sidebarTrendChart');
                if (sidebarChartInstance) {
                    sidebarChartInstance.destroy();
                    sidebarChartInstance = null;
                }

                if (sidebarCtx) {
                    const lastSevenLabels = dateLabels.slice(-7);
                    const lastSevenValues = dateValues.slice(-7);

                    sidebarChartInstance = new Chart(sidebarCtx, {
                    type: 'bar',
                    data: {
                        labels: lastSevenLabels,
                        datasets: [{
                            data: lastSevenValues,
                            backgroundColor: ['rgba(13, 148, 136, 0.92)', 'rgba(20, 184, 166, 0.92)', 'rgba(245, 158, 11, 0.92)', 'rgba(249, 115, 22, 0.92)', 'rgba(15, 118, 110, 0.92)', 'rgba(217, 119, 6, 0.92)', 'rgba(13, 148, 136, 0.92)'],
                            borderRadius: 6,
                            borderSkipped: false,
                            maxBarThickness: 18
                        }]
                    },
                    options: {
                        devicePixelRatio: dpr,
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleColor: '#f8fafc',
                                bodyColor: '#f8fafc',
                                displayColors: false,
                                callbacks: {
                                    label: (context) => `Rp ${rupiah.format(context.parsed.y || 0)}`,
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: { display: false },
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { display: false, precision: 0 },
                                grid: { color: 'rgba(148, 163, 184, 0.12)' }
                            }
                        }
                    }
                });
                }
            };

            renderDashboardCharts();
            window.addEventListener('resize', rerenderWithDebounce);

            const trendContainer = document.getElementById('revenueTrendChart');
            if (trendContainer && 'ResizeObserver' in window) {
                const trendResizeObserver = new ResizeObserver(rerenderWithDebounce);
                trendResizeObserver.observe(trendContainer);
            }

            window.addEventListener('theme-changed', renderDashboardCharts);
        })();
    </script>
@endsection
