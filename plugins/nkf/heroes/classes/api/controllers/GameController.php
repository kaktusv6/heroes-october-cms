<?php declare(strict_types=1);

namespace Nkf\Heroes\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Nkf\Heroes\Classes\Api\ApiController;
use Nkf\Heroes\Models\Game;

class GameController extends ApiController
{
    public function games(): JsonResponse
    {
        return $this->responseJson(Game::get()->toArray());
    }
}
