<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateSettingsRequest;
use App\Models\Setting;
use App\Support\StorageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;
use Throwable;

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
        $currentLogoPath = Setting::get('logo_path', '');
        $newLogoPath = null;

        try {
            if ($request->hasFile('logo')) {
                $storedPath = $request->file('logo')->store('branding', 'public');

                if (! is_string($storedPath)) {
                    throw new RuntimeException('The uploaded logo could not be stored.');
                }

                $newLogoPath = $storedPath;
            }

            $shouldUpdateLogo = $newLogoPath !== null || $request->boolean('remove_logo');
            $nextLogoPath = $newLogoPath ?? ($request->boolean('remove_logo') ? '' : $currentLogoPath);

            DB::transaction(function () use ($data, $shouldUpdateLogo, $nextLogoPath): void {
                foreach (self::TEXT_KEYS as $key) {
                    Setting::put($key, (string) ($data[$key] ?? ''));
                }

                if ($shouldUpdateLogo) {
                    Setting::put('logo_path', $nextLogoPath);
                }
            });
        } catch (Throwable $exception) {
            $this->deleteStoredFileWithoutMasking($newLogoPath);

            throw $exception;
        }

        if ($currentLogoPath !== '' && $currentLogoPath !== $nextLogoPath) {
            Storage::disk('public')->delete($currentLogoPath);
        }

        return to_route('dashboard.settings.site.edit')
            ->with('toast', ['type' => 'success', 'message' => 'Einstellungen gespeichert.']);
    }

    private function logoUrl(): ?string
    {
        return StorageUrl::for(Setting::get('logo_path'));
    }

    private function deleteStoredFileWithoutMasking(?string $path): void
    {
        if ($path === null) {
            return;
        }

        try {
            Storage::disk('public')->delete($path);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
