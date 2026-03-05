@extends('admin.layouts.app')

@section('content')
    <div class="space-y-5">
        <div class="rounded-xl border border-sky-100/80 bg-gradient-to-r from-white via-sky-50/55 to-indigo-50/55 p-5 shadow-sm dark:border-slate-800 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Produk</h1>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola produk, filter cepat, dan aksi massal dari satu halaman.</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="rounded-md bg-gradient-to-r from-sky-700 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:brightness-105">
                    Tambah Produk
                </a>
            </div>
        </div>

        <form method="GET" class="rounded-xl border border-sky-100/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari nama/deskripsi..." class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 md:col-span-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                <select name="category_ids[]" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(in_array($category->id, $filters['category_ids'], true))>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="only_active" value="1" class="h-4 w-4 accent-sky-600" @checked($filters['only_active'])> Hanya aktif</label>
                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="no_image" value="1" class="h-4 w-4 accent-sky-600" @checked($filters['no_image'])> Tanpa gambar</label>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button class="rounded-md bg-gradient-to-r from-sky-700 to-indigo-600 px-4 py-2 text-sm font-medium text-white hover:brightness-105">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Reset</a>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.products.bulk') }}" class="rounded-xl border border-sky-100/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @csrf
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                    Total: <span class="text-slate-900 dark:text-slate-100">{{ $products->total() }}</span> produk
                </p>
                <div class="flex items-center gap-2">
                <select name="action" required class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    <option value="">Bulk action</option>
                    <option value="activate">Aktifkan</option>
                    <option value="deactivate">Nonaktifkan</option>
                    <option value="delete">Hapus</option>
                </select>
                <button class="rounded-md bg-gradient-to-r from-sky-700 to-indigo-600 px-4 py-2 text-sm font-medium text-white hover:brightness-105">Terapkan</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/80 text-left text-slate-600 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-300">
                            <th class="py-3 pr-3"><input type="checkbox" id="check-all" class="h-4 w-4 accent-sky-600"></th>
                            <th class="py-3 pr-3">Gambar</th>
                            <th class="py-3 pr-3">Nama</th>
                            <th class="py-3 pr-3">Kategori</th>
                            <th class="py-3 pr-3">Harga</th>
                            <th class="py-3 pr-3">Aktif</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-b border-slate-100 transition hover:bg-slate-50/70 dark:border-slate-800 dark:hover:bg-slate-800/45">
                                <td class="py-3 pr-3 align-top"><input type="checkbox" name="ids[]" value="{{ $product->id }}" class="row-check h-4 w-4 accent-sky-600"></td>
                                <td class="py-3 pr-3">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                                    @else
                                        <span class="inline-flex rounded-md bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-slate-800 dark:text-slate-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-3">
                                    <p class="font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($product->description, 45) }}</p>
                                </td>
                                <td class="py-3 pr-3 text-slate-600 dark:text-slate-300">{{ $product->category?->name ?? '-' }}</td>
                                <td class="py-3 pr-3 text-slate-800 dark:text-slate-200">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                <td class="py-3 pr-3">
                                    <span class="rounded-full px-2 py-1 text-xs {{ $product->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.products.show', $product) }}" class="rounded border border-slate-300 px-2 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Lihat</a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded border border-slate-300 px-2 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Edit</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded border border-rose-300 px-2 py-1 text-xs font-medium text-rose-700 hover:bg-rose-50 dark:border-rose-900 dark:text-rose-300 dark:hover:bg-rose-950/50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-6 text-center text-slate-500 dark:text-slate-400">Belum ada data produk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $products->links() }}</div>
        </form>
    </div>

    <script>
        const checkAll = document.getElementById('check-all');
        const rowChecks = document.querySelectorAll('.row-check');
        checkAll?.addEventListener('change', function () {
            rowChecks.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
