<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableUpdateNkfHeroesCharacteristics extends Migration
{
    public function up()
    {
        Schema::table('nkf_heroes_characteristics', function(Blueprint $table)
        {
            $table->integer('game_id')->unsigned();

            $table->foreign('game_id')->on('nkf_heroes_games')->references('id');
        });
    }

    public function down()
    {
        Schema::table('nkf_heroes_characteristics', function(Blueprint $table)
        {
            $table->dropForeign(['game_id']);

            $table->dropColumn('game_id');
        });
    }
}
