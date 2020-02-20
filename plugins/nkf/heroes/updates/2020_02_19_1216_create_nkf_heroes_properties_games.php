<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class CreateNkfHeroesPropertiesGames extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_properties_games', function (Blueprint $table) : void {
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('property_id');
            $table->text('property_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_properties_games');
    }
}
