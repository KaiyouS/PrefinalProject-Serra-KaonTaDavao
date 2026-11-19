<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Kaiyou Serra',
            'email' => 'serra@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::factory()->create([
            'name' => 'Tita Serra',
            'email' => 'tita.serra@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::factory()->count(10)->create();
    }
}
