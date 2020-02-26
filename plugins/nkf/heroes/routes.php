<?php

Route::group(['prefix' => 'api', 'middleware' => []], function () {
    Route::get('/games', 'Nkf\Content\Controllers\GamesController@getAllGames');
});
