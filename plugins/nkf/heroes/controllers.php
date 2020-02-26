<?php declare(strict_types=1);

namespace Nkf\Content\Controllers;

use Nkf\Heroes\Models\Game;

class GamesController
{
    public function getAllGames(): string
    {
        $games = Game::get();
        return $games->toJson();
    }
}
