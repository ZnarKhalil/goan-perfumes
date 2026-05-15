<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->settings() as $key => $value) {
            Setting::put($key, $value);
        }
    }

    /**
     * @return array<string, string>
     */
    private function settings(): array
    {
        return [
            'whatsapp_number' => '+49 170 1234567',
            'email' => 'kontakt@goanperfume.de',
            'phone' => '+49 30 12345678',
            'instagram_url' => 'https://instagram.com/goanperfume',
            'tiktok_url' => 'https://tiktok.com/@goanperfume',
            'facebook_url' => 'https://facebook.com/goanperfume',
            'default_locale' => 'de',
            'logo_path' => '',
        ];
    }
}
