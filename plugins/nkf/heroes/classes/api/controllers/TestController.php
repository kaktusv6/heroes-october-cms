<?php declare(strict_types=1);

namespace Nkf\Heroes\Api\Controllers;

use Illuminate\Http\JsonResponse;
use Nkf\Heroes\Classes\Api\ApiController;

class TestController extends ApiController
{
    public function test(): JsonResponse
    {
        return $this->responseJson(['test success']);
    }
}
