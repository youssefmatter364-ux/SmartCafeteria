<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'Youssef&Amira@gmail.com'],
            [
                'name' => 'Youssef&Amira',
                'password' => Hash::make('01068127244'),
            ]
        );

        $this->call([
            CafeteriaSeeder::class,
        ]);
    }
}