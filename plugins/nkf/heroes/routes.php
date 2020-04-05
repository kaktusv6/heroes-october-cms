<?php declare(strict_types=1);

use Nkf\Content\ApiKey;
use Nkf\Content\TokenAuthenticate;
use Nkf\Heroes\Controllers\GamesController;
use Nkf\Heroes\Controllers\TestController;
use Nkf\Heroes\Controllers\UserController;

Route::group(['prefix' => 'api', 'middleware' => ApiKey::ALIAS], function () {
    Route::get('/', TestController::class . '@test');
    Route::post('/user/register', UserController::class . '@register');
    Route::post('/user/auth', UserController::class . '@auth');

    Route::group(['middleware' => TokenAuthenticate::ALIAS], function () {
        Route::get('games', GamesController::class . '@games');
        Route::get('test', TestController::class . '@test');
    });
});
