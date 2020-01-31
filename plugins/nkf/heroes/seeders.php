<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Illuminate\Database\Seeder;
use Nkf\Heroes\Models\Game;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'title' => 'Warhammer 40K: DH',
                'description' => 'desc'
            ],
            [
                'title' => 'D&D',
                'description' => 'desc 2'
            ]
        ];

        $gameIds = [];
        foreach ($games as $game) {
            $gameIds[] = Game::create($game)->id;

        }
    }
}
