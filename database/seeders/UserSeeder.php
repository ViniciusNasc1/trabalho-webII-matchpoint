<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin MatchPoint',
            'email'    => 'admin@matchpoint.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Player Um',
            'email'    => 'player1@matchpoint.com',
            'password' => Hash::make('password'),
            'role'     => 'player',
        ]);

        User::create([
            'name'     => 'Player Dois',
            'email'    => 'player2@matchpoint.com',
            'password' => Hash::make('password'),
            'role'     => 'player',
        ]);

        User::create([
            'name'     => 'Player Três',
            'email'    => 'player3@matchpoint.com',
            'password' => Hash::make('password'),
            'role'     => 'player',
        ]);
    }
}