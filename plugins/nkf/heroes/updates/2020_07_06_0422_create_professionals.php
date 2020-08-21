<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableCreateProfessionals extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_professionals', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('name', 250)->unique();
            $table->string('code', 250)->unique();
            $table->text('description')->nullable();
            $table->mediumText('condition')->nullable();
        });

        Schema::create('nkf_heroes_professionals_games', function (Blueprint $table) : void {
            $table->unsignedInteger('professional_id');
            $table->unsignedInteger('game_id');

            $table->foreign('professional_id', 'nkf_heroes_professionals_foreign_id')
                ->on('nkf_heroes_professionals')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('game_id')->on('nkf_heroes_games')->references('id')->onDelete('cascade');

            $table->primary(['professional_id', 'game_id'], 'nkf_heroes_professionals_games');
        });

        Schema::create('nkf_heroes_professionals_heroes', function (Blueprint $table) : void {
            $table->unsignedInteger('professional_id');
            $table->unsignedInteger('hero_id');

            $table->foreign('professional_id')
                ->on('nkf_heroes_professionals')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('hero_id')->on('nkf_heroes_heroes')->references('id')->onDelete('cascade');

            $table->primary(['professional_id', 'hero_id'], 'nkf_heroes_professionals_heroes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_professionals_heroes');
        Schema::dropIfExists('nkf_heroes_professionals_games');
        Schema::dropIfExists('nkf_heroes_professionals');
    }
}
