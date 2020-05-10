<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableRemovedPolymorphedRelationCharacteristicsAndGames extends Migration
{
    public function up()
    {
        Schema::dropIfExists('nkf_heroes_properties_games');
        Schema::create('nkf_heroes_characteristics_games', function (Blueprint $table) : void {
            $table->unsignedInteger('characteristic_id');
            $table->unsignedInteger('game_id');

            $table
                ->foreign('characteristic_id')
                ->on('nkf_heroes_characteristics')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('game_id')->on('nkf_heroes_games')->references('id');
            $table->primary(['characteristic_id', 'game_id'], 'nkf_heroes_characteristics_games_primary');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_characteristics_games');

        Schema::create('nkf_heroes_properties_games', function (Blueprint $table) : void {
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('property_id');
            $table->text('property_type');
        });
    }
}
