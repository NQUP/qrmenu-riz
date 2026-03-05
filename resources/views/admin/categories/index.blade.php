@extends('admin.layouts.app')

@section('content')
    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Kategori</h1>
            <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 px-4 py-2 text-sm font-medium text-white hover:brightness-105">
                Tambah Kategori
            </a>
        </div>

        <form method="GET" class="rounded-xl border border-cyan-100/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari nama/deskripsi..." class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 md:col-span-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="only_active" value="1" @checked($filters['only_active'])>
                    Hanya aktif
                </label>
            </div>
            <div class="mt-3 flex gap-2">
                <button class="rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 px-4 py-2 text-sm font-medium text-white hover:brightness-105">Filter</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Reset</a>
            </div>
        </form>

        <div class="rounded-xl border border-cyan-100/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-slate-500 dark:border-slate-700 dark:text-slate-400">
                            <th class="py-3 pr-3">Nama</th>
                            <th class="py-3 pr-3">Deskripsi</th>
                            <th class="py-3 pr-3">Warna</th>
                            <th class="py-3 pr-3">Produk</th>
                            <th class="py-3 pr-3">Status</th>
                            <th class="py-3 pr-3">Urutan</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <td class="py-3 pr-3 font-medium text-slate-800 dark:text-slate-200">{{ $category->name }}</td>
                                <td class="py-3 pr-3 text-slate-600 dark:text-slate-300">{{ \Illuminate\Support\Str::limit($category->description, 60) }}</td>
                                <td class="py-3 pr-3">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="inline-block h-4 w-4 rounded" style="background: {{ $category->color }}"></span>
                                        <span>{{ $category->color }}</span>
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-slate-700 dark:text-slate-300">{{ $category->products_count }}</td>
                                <td class="py-3 pr-3">
                                    <span class="rounded-full px-2 py-1 text-xs {{ $category->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-slate-700 dark:text-slate-300">{{ $category->sort_order }}</td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded border border-slate-300 px-2 py-1 text-xs text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded border border-rose-300 px-2 py-1 text-xs text-rose-700 hover:bg-rose-50 dark:border-rose-900 dark:text-rose-300 dark:hover:bg-rose-950/50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-6 text-center text-slate-500 dark:text-slate-400">Belum ada data kategori.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $categories->links() }}</div>
        </div>
    </div>
@endsection
