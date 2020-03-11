<?php

Route::group(['prefix' => 'api', 'middleware' => ['token_auth']], function () {
    Route::get('/games', 'Nkf\Content\Controllers\GamesController@getAllGames');
});
