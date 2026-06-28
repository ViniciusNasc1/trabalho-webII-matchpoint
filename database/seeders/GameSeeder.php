<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            ['name' => 'Counter-Strike 2',  'platform' => 'PC'],
            ['name' => 'Valorant',           'platform' => 'PC'],
            ['name' => 'League of Legends',  'platform' => 'PC'],
            ['name' => 'FIFA 25',            'platform' => 'PS5'],
            ['name' => 'Mortal Kombat 1',    'platform' => 'PS5'],
            ['name' => 'Street Fighter 6',   'platform' => 'PC'],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}