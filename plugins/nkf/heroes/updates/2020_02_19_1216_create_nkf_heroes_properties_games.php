<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class CreateNkfHeroesPropertiesGames extends Migration
{
    public function up()
    {
        Schema::table('nkf_heroes_characteristics', function(Blueprint $table)
        {
            $table->dropForeign(['game_id']);

            $table->dropColumn('game_id');
        });

        Schema::create('nkf_heroes_properties_games', function($table)
        {
            $table->integer('game_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->text('property_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_properties_games');
        Schema::table('nkf_heroes_characteristics', function(Blueprint $table)
        {
            $table->unsignedInteger('game_id');

            $table->foreign('game_id')->on('nkf_heroes_games')->references('id');
        });
    }
}
