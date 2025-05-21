<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Создаем админа
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Создаем модератора
        User::create([
            'name' => 'Moderator',
            'email' => 'moder@example.com',
            'password' => Hash::make('password'),
            'role' => 'moder'
        ]);

        // Создаем обычного пользователя
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}
