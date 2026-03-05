@extends('site.layouts.app')
@section('content')
    <section id="produk" class="mb-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Pilihan</p>
                <h2 class="text-3xl md:text-4xl font-semibold text-slate-900">
                    Produk Kami
                </h2>
            </div>
            <div class="hidden md:flex items-center gap-3 text-sm text-slate-500">
                <span class="material-symbols-outlined text-base">verified</span>
                Bahan pilihan, kualitas terjaga
            </div>
        </div>
        <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if (isset($products) && $products->count() > 0)
                @foreach ($products as $product)
                    <div class="product-item bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-500 transform hover:-translate-y-1 border border-slate-200 group h-full flex flex-col"
                        data-category="{{ $product->category_id }}">
                        <div class="h-56 bg-slate-100 relative overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . ltrim($product->image, '/')) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100">
                                    <span class="material-symbols-outlined text-slate-400 text-6xl transition-colors duration-300 group-hover:text-slate-600">restaurant</span>
                                </div>
                            @endif
                            @if ($product->category)
                                <div class="absolute top-4 right-4 text-white text-xs px-3 py-1 rounded-full font-medium tracking-wide shadow-lg transition-all duration-300"
                                    style="background-color: {{ $product->category->color ?? '#000000' }};">
                                    {{ $product->category->name }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/5 transition-all duration-300"></div>
                        </div>
                        <div class="p-6 flex flex-col h-full">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h3 class="text-lg font-semibold text-slate-900 group-hover:text-slate-700 transition-colors duration-300">
                                    {{ $product->name }}
                                </h3>
                                <span class="text-amber-600 text-lg font-semibold whitespace-nowrap">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex-1">
                                @if ($product->description)
                                    <p class="text-slate-600 text-sm leading-relaxed">
                                        {{ Str::limit($product->description, 120) }}
                                    </p>
                                @else
                                    <p class="text-slate-400 text-sm">Deskripsi belum tersedia.</p>
                                @endif
                            </div>
                            <a
                                class="inline-flex items-center justify-center mt-5 w-full rounded-full bg-slate-900 text-white px-4 py-2.5 text-sm tracking-wide hover:bg-slate-800 transition-colors duration-300"
                                href="{{ route('orders.create', ['product' => $product->id]) }}"
                            >
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-16">
                    <div class="text-slate-500">
                        <span class="material-symbols-outlined text-8xl mb-6 block opacity-50">restaurant_menu</span>
                        <h3 class="text-3xl font-semibold mb-4 tracking-wide text-slate-900">Belum Ada Produk Ditambahkan</h3>
                        <p class="text-slate-400 text-lg">Segera Anda dapat menemukan produk lezat kami di sini.</p>
                    </div>
                </div>
            @endif
        </div>

        <div id="no-products-message" class="text-center py-16 hidden">
            <div class="text-slate-500">
                <span class="material-symbols-outlined text-8xl mb-6 block opacity-50">search_off</span>
                <h3 class="text-3xl font-semibold mb-4 tracking-wide text-slate-900">Tidak Ada Produk di Kategori Ini</h3>
                <p class="text-slate-400 text-lg">Pilih kategori lain untuk menemukan menu lainnya.</p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const productItems = document.querySelectorAll('.product-item');
            const noProductsMessage = document.getElementById('no-products-message');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedCategory = this.getAttribute('data-category');

                    // Perbarui gaya tombol
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('bg-slate-900', 'text-white');
                        btn.classList.add('bg-white', 'text-slate-700');
                        btn.classList.add('border', 'border-slate-200');
                    });
                    this.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');
                    this.classList.add('bg-slate-900', 'text-white');

                    // Filter produk
                    let visibleProductsCount = 0;
                    productItems.forEach(item => {
                        const productCategory = item.getAttribute('data-category');

                        if (selectedCategory === 'all' || productCategory ===
                            selectedCategory) {
                            item.style.display = 'block';
                            visibleProductsCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Tampilkan pesan jika tidak ada produk yang terlihat
                    if (visibleProductsCount === 0) {
                        noProductsMessage.classList.remove('hidden');
                    } else {
                        noProductsMessage.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection
