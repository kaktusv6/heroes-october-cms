<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class CreateNkfHeroesHomeWorlds extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_home_worlds', function (Blueprint $table) : void {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('title');
        });

        Schema::table('nkf_heroes_heroes', function (BLueprint $table) : void {
            $table->unsignedInteger('home_world_id')->nullable();

            $table->foreign('home_world_id')->on('nkf_heroes_home_worlds')->references('id');
        });
    }

    public function down()
    {
        Schema::table('nkf_heroes_heroes', function (BLueprint $table) : void {
            $table->dropForeign(['home_world_id']);
            $table->dropColumn(['home_world_id']);
        });

        Schema::dropIfExists('nkf_heroes_home_worlds');
    }
}
