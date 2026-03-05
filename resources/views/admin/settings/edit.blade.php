@extends('admin.layouts.app')

@section('content')
<div class="space-y-5">
    <div class="rounded-xl border border-sky-100/80 bg-gradient-to-r from-white via-sky-50/45 to-indigo-50/45 p-5 shadow-sm dark:border-slate-800 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Pengaturan Situs</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola identitas brand, kontak, sosial media, dan SEO dari satu halaman.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <section class="rounded-xl border border-teal-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Informasi Umum</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Data utama yang ditampilkan di halaman publik.</p>
            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Perusahaan</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div class="flex items-center">
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                            <input type="checkbox" name="is_maintenance" value="1" @checked((bool) old('is_maintenance', $setting->is_maintenance))>
                            Mode Perawatan
                        </label>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Saat aktif, pengunjung akan melihat status maintenance sementara admin tetap bisa mengelola panel.
                        </p>
                    </div>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                    <input type="email" name="site_email" value="{{ old('site_email', $setting->site_email) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                    <input type="text" name="site_phone" value="{{ old('site_phone', $setting->site_phone) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Alamat</label>
                    <textarea name="site_address" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('site_address', $setting->site_address) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Jam Operasional</label>
                    <textarea name="site_working_hours" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('site_working_hours', $setting->site_working_hours) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Embed Maps</label>
                    <textarea name="site_maps_embed" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('site_maps_embed', $setting->site_maps_embed) }}</textarea>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-teal-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Branding</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Upload aset visual utama website Anda.</p>
            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Logo</label>
                    <input type="file" name="site_logo" accept="image/*" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    @if ($setting->site_logo)
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $setting->site_logo) }}" alt="Logo" class="h-12 w-12 rounded object-cover">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                            <input type="checkbox" name="remove_site_logo" value="1">
                            Hapus logo
                        </label>
                    </div>
                    @endif
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Favicon</label>
                    <input type="file" name="site_favicon" accept="image/*" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    @if ($setting->site_favicon)
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $setting->site_favicon) }}" alt="Favicon" class="h-12 w-12 rounded object-cover">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                            <input type="checkbox" name="remove_site_favicon" value="1">
                            Hapus favicon
                        </label>
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-teal-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Sosial Media</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Gunakan URL lengkap termasuk `https://`.</p>
            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Facebook URL</label>
                    <input type="url" name="site_facebook_url" value="{{ old('site_facebook_url', $setting->site_facebook_url) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Twitter/X URL</label>
                    <input type="url" name="site_twitter_url" value="{{ old('site_twitter_url', $setting->site_twitter_url) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Instagram URL</label>
                    <input type="url" name="site_instagram_url" value="{{ old('site_instagram_url', $setting->site_instagram_url) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">LinkedIn URL</label>
                    <input type="url" name="site_linkedin_url" value="{{ old('site_linkedin_url', $setting->site_linkedin_url) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">YouTube URL</label>
                    <input type="url" name="site_youtube_url" value="{{ old('site_youtube_url', $setting->site_youtube_url) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-teal-100/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">SEO</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Optimasi judul dan metadata untuk mesin pencari.</p>
            <div class="mt-4 grid grid-cols-1 gap-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">SEO Title</label>
                    <input type="text" name="site_seo_title" value="{{ old('site_seo_title', $setting->site_seo_title) }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">SEO Description</label>
                    <textarea name="site_seo_description" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('site_seo_description', $setting->site_seo_description) }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">SEO Keywords</label>
                    <textarea name="site_seo_keywords" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ old('site_seo_keywords', $setting->site_seo_keywords) }}</textarea>
                </div>
            </div>
        </section>
        <div class="flex justify-start">
            <button class="rounded-full bg-gradient-to-r from-sky-700 to-indigo-600 px-5 py-2 text-sm font-medium text-white hover:brightness-105">Simpan Pengaturan</button>
        </div>
</div>
</form>
</div>
@endsection
