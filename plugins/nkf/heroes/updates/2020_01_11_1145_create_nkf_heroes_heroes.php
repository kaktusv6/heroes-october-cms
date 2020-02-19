<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateHeroesTable extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_heroes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('user_id');

            $table->foreign('game_id')->on('nkf_heroes_games')->references('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_heroes');
    }
}
