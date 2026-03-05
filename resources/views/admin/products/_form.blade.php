@php
    $isEdit = isset($product->id);
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Kategori</label>
        <select name="category_id" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === (int) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Harga</label>
        <input type="number" min="0" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Gambar Produk</label>
        <input type="file" name="image" accept="image/*" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
        @if ($isEdit && $product->image)
            <div class="mt-2 flex items-center gap-3">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-md object-cover">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="remove_image" value="1">
                    Hapus gambar saat simpan
                </label>
            </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
            <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $product->is_active ?? true))>
            Aktif
        </label>
    </div>
</div>
