<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('description', $category->description) }}</textarea>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Warna</label>
        <input type="color" name="color" value="{{ old('color', $category->color ?: '#000000') }}" required class="h-10 w-full rounded-lg border border-slate-300 bg-white px-2 py-1 dark:border-slate-700 dark:bg-slate-800">
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Ikon (opsional)</label>
        <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="heroicon-o-star" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Urutan</label>
        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
    </div>

    <div class="flex items-center">
        <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
            <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $category->is_active ?? true))>
            Aktif
        </label>
    </div>
</div>
