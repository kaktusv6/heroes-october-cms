<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNkfHeroesGames extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_games', function (Blueprint $table) : void {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_games');
    }
}
