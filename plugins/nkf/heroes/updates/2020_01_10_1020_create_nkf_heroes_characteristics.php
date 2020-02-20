<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNkfHeroesCharacteristics extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_characteristics', function (Blueprint $table) : void {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->mediumText('range');
            $table->mediumText('range_generator');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_characteristics');
    }
}
