@extends('admin.layouts.app')

@section('content')
    <div class="space-y-4">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Pesanan</h1>
        <!-- <div class="rounded-xl border border-cyan-100/80 bg-cyan-50/60 p-4 text-sm text-slate-700 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
            <p class="font-semibold text-slate-800 dark:text-slate-100">Aksi pesanan:</p>
            <p class="mt-1">
                <strong>Detail</strong> untuk melihat detail pesanan,
                <strong>Konfirm</strong> untuk kirim notifikasi WhatsApp bahwa pesanan selesai dibuat dan siap dibayar,
                <strong>Selesai</strong> untuk pesanan yang sudah dibayar agar masuk ke total pendapatan dashboard,
                <strong>Hapus</strong> untuk menghapus pesanan.
            </p>
        </div> -->

        <form method="GET" class="rounded-xl border border-cyan-100/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari ID/Nama/No. telepon..." class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 md:col-span-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                <select name="status" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                    <option value="">Semua status</option>
                    <option value="baru" @selected($filters['status'] === 'baru')>Baru</option>
                    <option value="diproses" @selected($filters['status'] === 'diproses')>Diproses</option>
                    <option value="selesai" @selected($filters['status'] === 'selesai')>Selesai</option>
                    <option value="batal" @selected($filters['status'] === 'batal')>Batal</option>
                </select>
            </div>
            <div class="mt-3 flex gap-2">
                <button class="rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 px-4 py-2 text-sm font-medium text-white hover:brightness-105">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Reset</a>
            </div>
        </form>

        <div class="rounded-xl border border-cyan-100/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-slate-500 dark:border-slate-700 dark:text-slate-400">
                            <th class="py-3 pr-3">#</th>
                            <th class="py-3 pr-3">Nama</th>
                            <th class="py-3 pr-3">Telepon</th>
                            <th class="py-3 pr-3">Meja</th>
                            <th class="py-3 pr-3">Total</th>
                            <th class="py-3 pr-3">Status</th>
                            <th class="py-3 pr-3">Waktu</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <td class="py-3 pr-3 text-slate-700 dark:text-slate-300">#{{ $order->id }}</td>
                                <td class="py-3 pr-3 font-medium text-slate-800 dark:text-slate-200">{{ $order->name }}</td>
                                <td class="py-3 pr-3 text-slate-700 dark:text-slate-300">{{ $order->phone }}</td>
                                <td class="py-3 pr-3 text-slate-700 dark:text-slate-300">{{ $order->table_number ?: '-' }}</td>
                                <td class="py-3 pr-3 text-slate-800 dark:text-slate-200">Rp {{ number_format((float) $order->total, 0, ',', '.') }}</td>
                                <td class="py-3 pr-3">
                                    @php
                                        $statusClasses = [
                                            'baru' => 'bg-sky-100 text-sky-700',
                                            'diproses' => 'bg-amber-100 text-amber-700',
                                            'selesai' => 'bg-emerald-100 text-emerald-700',
                                            'batal' => 'bg-rose-100 text-rose-700',
                                        ];
                                    @endphp
                                    <span class="rounded-full px-2 py-1 text-xs {{ $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-700' }} dark:bg-slate-800 dark:text-slate-300">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 pr-3 text-slate-600 dark:text-slate-400">{{ $order->created_at?->format('d.m.Y H:i') }}</td>
                                <td class="py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="rounded border border-slate-300 px-2 py-1 text-xs text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Detail</a>
                                        @if ($order->status === 'baru')
                                            <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="rounded border border-emerald-300 px-2 py-1 text-xs text-emerald-700 hover:bg-emerald-50 dark:border-emerald-900 dark:text-emerald-300 dark:hover:bg-emerald-950/50">Konfirm</button>
                                            </form>
                                        @endif
                                        @if ($order->status === 'diproses')
                                            <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="rounded border border-blue-300 px-2 py-1 text-xs text-blue-700 hover:bg-blue-50 dark:border-blue-900 dark:text-blue-300 dark:hover:bg-blue-950/50">Selesai</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded border border-rose-300 px-2 py-1 text-xs text-rose-700 hover:bg-rose-50 dark:border-rose-900 dark:text-rose-300 dark:hover:bg-rose-950/50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="py-6 text-center text-slate-500 dark:text-slate-400">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
@endsection
