<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateSettingsRequest;
use App\Models\Setting;
use App\Support\StorageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    private const TEXT_KEYS = [
        'whatsapp_number',
        'email',
        'phone',
        'instagram_url',
        'tiktok_url',
        'facebook_url',
        'default_locale',
    ];

    public function edit(): Response
    {
        return Inertia::render('dashboard/settings/site', [
            'settings' => [
                'whatsapp_number' => Setting::get('whatsapp_number', ''),
                'email' => Setting::get('email', ''),
                'phone' => Setting::get('phone', ''),
                'instagram_url' => Setting::get('instagram_url', ''),
                'tiktok_url' => Setting::get('tiktok_url', ''),
                'facebook_url' => Setting::get('facebook_url', ''),
                'default_locale' => Setting::get('default_locale', 'de'),
                'logo_path' => Setting::get('logo_path', ''),
                'logo_url' => $this->logoUrl(),
            ],
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach (self::TEXT_KEYS as $key) {
            Setting::put($key, (string) ($data[$key] ?? ''));
        }

        $currentLogoPath = Setting::get('logo_path', '');

        if ($request->boolean('remove_logo') && $currentLogoPath !== '') {
            Setting::put('logo_path', '');
            Storage::disk('public')->delete($currentLogoPath);
            $currentLogoPath = '';
        }

        if ($request->hasFile('logo')) {
            Setting::put(
                'logo_path',
                $request->file('logo')->store('branding', 'public'),
            );

            // Remove the previous file only after the new path is persisted.
            if ($currentLogoPath !== '') {
                Storage::disk('public')->delete($currentLogoPath);
            }
        }

        return to_route('dashboard.settings.site.edit')
            ->with('toast', ['type' => 'success', 'message' => 'Einstellungen gespeichert.']);
    }

    private function logoUrl(): ?string
    {
        return StorageUrl::for(Setting::get('logo_path'));
    }
}
