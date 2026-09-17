<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Institution::firstOrCreate(['name' => 'Latis Education']);
        Institution::firstOrCreate(['name' => 'Tutor Indonesia']);

        User::firstOrCreate(
            ['email' => 'admin@latis.com'],
            [
                'name' => 'Kandidat Admin',
                'password' => Hash::make('password123'),
                'position' => 'Fullstack Developer',
                'image' => null,
            ]
        );
    }
}
