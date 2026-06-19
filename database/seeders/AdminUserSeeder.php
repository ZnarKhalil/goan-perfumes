<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()
            ->firstOrNew(['email' => 'admin@goanperfume.de'])
            ->forceFill([
                'name' => 'Goan Perfume Admin',
                'password' => Hash::make(config('auth.admin_password')),
                'is_admin' => true,
                'email_verified_at' => now(),
            ])
            ->save();
    }
}
