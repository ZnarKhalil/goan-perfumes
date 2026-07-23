<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@goanperfume.de')->first();

        if ($admin instanceof User) {
            $admin->forceFill(['is_admin' => true])->save();

            return;
        }

        $password = config('auth.admin_password');

        if (! is_string($password) || trim($password) === '') {
            throw new RuntimeException('ADMIN_PASSWORD must be configured before creating the admin account.');
        }

        User::query()->forceCreate([
            'name' => 'Goan Perfume Admin',
            'email' => 'admin@goanperfume.de',
            'password' => Hash::make($password),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
