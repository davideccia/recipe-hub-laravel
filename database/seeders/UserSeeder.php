<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserRoleEnum::cases() as $role) {
            User::firstOrCreate([
                'email' => "{$role->value}@example.it",
            ], [
                'role' => $role,
                'password' => '12345678',
                'last_name' => \Str::ucfirst($role->value),
                'first_name' => 'User',
            ]);
        }
    }
}
