<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableCreateFieldsForHeroes extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_fields', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('code', 100)->unique();
            $table->string('type', 100);
            $table->text('description')->nullable();
            $table->mediumText('generate_data')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
        });

        Schema::create('nkf_heroes_fields_games', function (Blueprint $table) : void {
            $table->unsignedInteger('field_id');
            $table->unsignedInteger('game_id');

            $table->foreign('field_id')->on('nkf_heroes_fields')->references('id');
            $table->foreign('game_id')->on('nkf_heroes_games')->references('id');
            $table->primary(['field_id', 'game_id'], 'nkf_heroes_fields_games_primary');
        });

        Schema::create('nkf_heroes_fields_heroes', function (Blueprint $table) : void {
            $table->unsignedInteger('field_id');
            $table->unsignedInteger('hero_id');
            $table->text('value')->nullable();

            $table->foreign('field_id')->on('nkf_heroes_fields')->references('id');
            $table->foreign('hero_id')->on('nkf_heroes_heroes')->references('id')->onDelete('cascade');
            $table->primary(['field_id', 'hero_id'], 'nkf_heroes_fields_heroes_primary');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_fields_heroes');
        Schema::dropIfExists('nkf_heroes_fields_games');
        Schema::dropIfExists('nkf_heroes_fields');
    }
}
