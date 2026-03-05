@extends('admin.layouts.app')

@section('content')
    <div class="rounded-xl border border-cyan-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h1 class="mb-4 text-2xl font-semibold text-slate-900 dark:text-slate-100">Tambah Kategori</h1>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            @include('admin.categories._form')
            <div class="flex gap-2">
                <button class="rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 px-4 py-2 text-sm font-medium text-white hover:brightness-105">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Batal</a>
            </div>
        </form>
    </div>
@endsection
