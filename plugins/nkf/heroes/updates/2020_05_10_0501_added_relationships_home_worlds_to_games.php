<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableAddedRelationshipsHomeWorldsToGames extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_home_worlds_games', function (Blueprint $table) : void {
            $table->unsignedInteger('home_world_id');
            $table->unsignedInteger('game_id');

            $table->foreign('home_world_id')->on('nkf_heroes_home_worlds')->references('id')->onDelete('cascade');
            $table->foreign('game_id')->on('nkf_heroes_games')->references('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_home_worlds_games');
    }
}
