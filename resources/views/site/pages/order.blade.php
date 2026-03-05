@extends('site.layouts.app')

@section('content')
<section class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-3xl font-light text-black tracking-wide">Pesan Sekarang</h2>
    </div>
    <p class="text-gray-600 text-sm font-light mb-8">
        Isi formulir di bawah ini, kami akan menghubungi Anda untuk konfirmasi pesanan.
    </p>

    @if (session('order_success'))
    <div class="mb-6 border border-green-600 text-green-700 px-4 py-3 text-sm">
        {{ session('order_success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-6 border border-red-600 text-red-700 px-4 py-3 text-sm">
        Periksa kembali isian Anda.
    </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border border-gray-300 px-3 py-2"
                required />
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">No. WA(Aktif)</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                class="w-full border border-gray-300 px-3 py-2"
                required />
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">
                Nomor Meja
            </label>

            <input
                type="text"
                name="table_number"
                value="{{ old('table_number') }}"
                class="w-full border border-gray-300 px-3 py-2 rounded"
                placeholder="Contoh: 01" />
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-2">Pesanan</label>
            <div id="order-items" class="space-y-3">
                @php
                $oldProductIds = old('items_product_id', []);
                $rows = max(count($oldProductIds), 1);
                @endphp
                @for ($i = 0; $i < $rows; $i++)
                    <div class="order-row grid grid-cols-12 gap-3">
                    <div class="col-span-8">
                        <select
                            name="items_product_id[]"
                            class="w-full border border-gray-300 px-3 py-2"
                            required>
                            <option value="">Pilih produk</option>
                            @foreach ($products as $p)
                            @php
                            $selected = '';
                            if (old('items_product_id.' . $i) == $p->id) {
                            $selected = 'selected';
                            } elseif (! old('items_product_id') && $product && $product->id === $p->id && $i === 0) {
                            $selected = 'selected';
                            }
                            @endphp
                            <option value="{{ $p->id }}" data-price="{{ (float) $p->price }}" {{ $selected }}>
                                {{ $p->name }} - Rp {{ number_format($p->price, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input
                            type="number"
                            name="items_qty[]"
                            min="1"
                            value="{{ old('items_qty.' . $i, 1) }}"
                            class="w-full border border-gray-300 px-3 py-2"
                            required />
                    </div>
                    <div class="col-span-1 flex items-center">
                        <button type="button" class="remove-row text-red-600 text-sm">Hapus</button>
                    </div>
            </div>
            @endfor
        </div>
        <div class="mt-3">
            <button type="button" id="add-row" class="text-sm text-slate-700 underline">Tambah produk</button>
        </div>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Catatan (opsional)</label>
            <textarea
                name="notes"
                rows="3"
                class="w-full border border-gray-300 px-3 py-2">{{ old('notes') }}</textarea>
        </div>

        <div class="flex items-center justify-between gap-3">
            <button
                type="submit"
                class="inline-flex items-center justify-center border border-black text-black px-6 py-3 text-sm tracking-wide hover:bg-black hover:text-white transition-colors duration-300">
                Kirim Pesanan
            </button>
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center justify-center border border-gray-300 text-gray-700 px-6 py-3 text-sm tracking-wide hover:border-gray-400 hover:text-gray-900 transition-colors duration-300">
                Batal
            </a>
        </div>
        <div class="mt-4">
            <p class="text-base font-semibold text-slate-900">
                Total: <span id="order-total">Rp 0</span>
            </p>

            <p class="text-sm text-slate-600">
                Pembayaran di kasir.
            </p>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('order-items');
        const addRowBtn = document.getElementById('add-row');

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }

        function updateTotal() {
            let total = 0;
            const rows = container.querySelectorAll('.order-row');
            rows.forEach((row) => {
                const select = row.querySelector('select');
                const qtyInput = row.querySelector('input[type="number"]');
                const option = select.options[select.selectedIndex];
                const price = option ? Number(option.dataset.price || 0) : 0;
                const qty = Number(qtyInput.value || 0);
                total += price * qty;
            });
            const totalEl = document.getElementById('order-total');
            if (totalEl) {
                totalEl.textContent = 'Rp ' + formatRupiah(total);
            }
        }

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.order-row');
            rows.forEach((row) => {
                const btn = row.querySelector('.remove-row');
                btn.style.visibility = rows.length === 1 ? 'hidden' : 'visible';
            });
        }

        function createRow() {
            const firstRow = container.querySelector('.order-row');
            const row = firstRow.cloneNode(true);
            const select = row.querySelector('select');
            const qty = row.querySelector('input[type="number"]');
            select.value = '';
            qty.value = 1;
            return row;
        }

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                const rows = container.querySelectorAll('.order-row');
                if (rows.length > 1) {
                    e.target.closest('.order-row').remove();
                    updateRemoveButtons();
                    updateTotal();
                }
            }
        });

        addRowBtn.addEventListener('click', function() {
            container.appendChild(createRow());
            updateRemoveButtons();
            updateTotal();
        });

        container.addEventListener('change', function(e) {
            if (e.target.matches('select, input[type="number"]')) {
                updateTotal();
            }
        });

        container.addEventListener('input', function(e) {
            if (e.target.matches('input[type="number"]')) {
                updateTotal();
            }
        });

        updateRemoveButtons();
        updateTotal();
    });
</script>
@endsection