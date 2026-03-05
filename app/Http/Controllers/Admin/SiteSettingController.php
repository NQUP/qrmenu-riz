<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $setting = SiteSetting::query()->firstOrCreate(
            [],
            ['site_name' => config('app.name')]
        );

        return view('admin.settings.edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = SiteSetting::query()->firstOrCreate(
            [],
            ['site_name' => config('app.name')]
        );

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'site_email' => ['nullable', 'email', 'max:100'],
            'site_phone' => ['nullable', 'string', 'max:20'],
            'site_address' => ['nullable', 'string', 'max:200'],
            'site_working_hours' => ['nullable', 'string', 'max:100'],
            'site_maps_embed' => ['nullable', 'string'],
            'site_facebook_url' => ['nullable', 'url'],
            'site_twitter_url' => ['nullable', 'url'],
            'site_instagram_url' => ['nullable', 'url'],
            'site_linkedin_url' => ['nullable', 'url'],
            'site_youtube_url' => ['nullable', 'url'],
            'site_seo_title' => ['nullable', 'string', 'max:255'],
            'site_seo_description' => ['nullable', 'string'],
            'site_seo_keywords' => ['nullable', 'string'],
            'site_logo' => ['nullable', 'image', 'max:2048'],
            'site_favicon' => ['nullable', 'image', 'max:1024'],
        ]);

        $data['is_maintenance'] = $request->boolean('is_maintenance');

        if ($request->hasFile('site_logo')) {
            if ($setting->site_logo) {
                Storage::disk('public')->delete($setting->site_logo);
            }
            $data['site_logo'] = $request->file('site_logo')->store('sites', 'public');
        }

        if ($request->hasFile('site_favicon')) {
            if ($setting->site_favicon) {
                Storage::disk('public')->delete($setting->site_favicon);
            }
            $data['site_favicon'] = $request->file('site_favicon')->store('sites', 'public');
        }

        if ($request->boolean('remove_site_logo')) {
            if ($setting->site_logo) {
                Storage::disk('public')->delete($setting->site_logo);
            }
            $data['site_logo'] = null;
        }

        if ($request->boolean('remove_site_favicon')) {
            if ($setting->site_favicon) {
                Storage::disk('public')->delete($setting->site_favicon);
            }
            $data['site_favicon'] = null;
        }

        $setting->update($data);
        SiteSetting::clearCache();

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}
