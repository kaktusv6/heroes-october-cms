<?php declare(strict_types=1);

use Nkf\Content\ApiKey;
use Nkf\Content\TokenAuthenticate;
use Nkf\Heroes\Api\Controllers\GameController;
use Nkf\Heroes\Api\Controllers\HeroController;
use Nkf\Heroes\Api\Controllers\TestController;
use Nkf\Heroes\Api\Controllers\UserController;

Route::group(['prefix' => 'api', 'middleware' => ApiKey::ALIAS], function () {
    Route::get('/', TestController::class . '@test');
    Route::post('/user/register', UserController::class . '@register');
    Route::post('/user/login', UserController::class . '@login');

    Route::group(['middleware' => TokenAuthenticate::ALIAS], function () {
        Route::get('games', GameController::class . '@games');
        Route::get('test', TestController::class . '@test');
        Route::post('/user/logout', UserController::class . '@logout');

        Route::get('heroes', HeroController::class . '@heroesUser');
        Route::group(['prefix' => 'hero'], function () {
            Route::post('/', HeroController::class . '@hero');
            // TODO: Develop new routes for update data hero
            Route::delete('remove', HeroController::class . '@remove');
        });
    });
});
