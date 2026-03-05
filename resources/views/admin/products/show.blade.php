@extends('admin.layouts.app')

@section('content')
    <div class="rounded-xl border border-cyan-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="mb-4 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $product->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Edit</a>
                <a href="{{ route('admin.products.index') }}" class="rounded-md bg-gradient-to-r from-blue-600 to-cyan-500 px-3 py-2 text-sm font-medium text-white hover:brightness-105">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Kategori</p>
                <p class="font-medium text-slate-800 dark:text-slate-200">{{ $product->category?->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Harga</p>
                <p class="font-medium text-slate-800 dark:text-slate-200">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
                <p class="font-medium text-slate-800 dark:text-slate-200">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Dibuat</p>
                <p class="font-medium text-slate-800 dark:text-slate-200">{{ $product->created_at?->format('d.m.Y H:i') }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-slate-500 dark:text-slate-400">Deskripsi</p>
                <p class="font-medium text-slate-800 dark:text-slate-200">{{ $product->description ?: '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="mb-2 text-sm text-slate-500 dark:text-slate-400">Gambar</p>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-48 rounded-md object-cover">
                @else
                    <p class="text-slate-500 dark:text-slate-400">Tidak ada gambar.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
