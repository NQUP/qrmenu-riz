@extends('admin.layouts.app')

@section('content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Detail Pesanan #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 px-3 py-2 text-sm font-medium text-white hover:brightness-105">Kembali</a>
        </div>

        <div class="rounded-xl border border-cyan-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div><p class="text-sm text-slate-500 dark:text-slate-400">Nama</p><p class="font-medium text-slate-800 dark:text-slate-200">{{ $order->name }}</p></div>
                <div><p class="text-sm text-slate-500 dark:text-slate-400">No. WA(Aktif)</p><p class="font-medium text-slate-800 dark:text-slate-200">{{ $order->phone }}</p></div>
                <div><p class="text-sm text-slate-500 dark:text-slate-400">Nomor Meja</p><p class="font-medium text-slate-800 dark:text-slate-200">{{ $order->table_number ?: '-' }}</p></div>
                <!-- <div><p class="text-sm text-slate-500 dark:text-slate-400">Alamat</p><p class="font-medium text-slate-800 dark:text-slate-200">{{ $order->address ?: '-' }}</p></div> -->
                <div><p class="text-sm text-slate-500 dark:text-slate-400">Dibuat</p><p class="font-medium text-slate-800 dark:text-slate-200">{{ $order->created_at?->format('d.m.Y H:i') }}</p></div>
                <div><p class="text-sm text-slate-500 dark:text-slate-400">Total</p><p class="font-medium text-slate-800 dark:text-slate-200">Rp {{ number_format((float) $order->total, 0, ',', '.') }}</p></div>
            </div>

            <div class="mt-5">
                <p class="mb-2 text-sm text-slate-500 dark:text-slate-400">Daftar Item</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-left text-slate-500 dark:border-slate-700 dark:text-slate-400">
                                <th class="py-2 pr-3">Nama Item</th>
                                <th class="py-2 pr-3">Qty</th>
                                <th class="py-2 pr-3">Harga</th>
                                <th class="py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr class="border-b border-slate-100 dark:border-slate-800">
                                    <td class="py-2 pr-3 text-slate-700 dark:text-slate-300">{{ $item['name'] ?? '-' }}</td>
                                    <td class="py-2 pr-3 text-slate-700 dark:text-slate-300">{{ $item['qty'] ?? 0 }}</td>
                                    <td class="py-2 pr-3 text-slate-700 dark:text-slate-300">Rp {{ number_format((float) ($item['price'] ?? 0), 0, ',', '.') }}</td>
                                    <td class="py-2 text-slate-800 dark:text-slate-200">Rp {{ number_format((float) ($item['subtotal'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-4 text-center text-slate-500 dark:text-slate-400">Item tidak tersedia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5">
                <p class="text-sm text-slate-500 dark:text-slate-400">Catatan</p>
                <p class="font-medium text-slate-800 dark:text-slate-200">{{ $order->notes ?: '-' }}</p>
            </div>
        </div>

        <div class="rounded-xl border border-cyan-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="mb-3 text-lg font-semibold text-slate-900 dark:text-slate-100">Aksi Pesanan</h2>
            <div class="flex flex-wrap gap-3">
                @if ($order->status === 'baru')
                    <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-100 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-300 dark:hover:bg-emerald-950">
                            Konfirm + Kirim WA
                        </button>
                    </form>
                @endif

                @if ($order->status === 'diproses')
                    <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-lg border border-blue-300 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-950/50 dark:text-blue-300 dark:hover:bg-blue-950">
                            Selesai
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg border border-rose-300 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-700 hover:bg-rose-100 dark:border-rose-900 dark:bg-rose-950/50 dark:text-rose-300 dark:hover:bg-rose-950">Hapus Pesanan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
