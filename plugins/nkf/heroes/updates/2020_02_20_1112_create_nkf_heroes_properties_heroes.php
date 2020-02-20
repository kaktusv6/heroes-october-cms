<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class CreateNkfHeroesPropertiesHeroes extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_properties_heroes', function (Blueprint $table) : void {
            $table->unsignedInteger('hero_id');
            $table->unsignedInteger('property_id');
            $table->text('property_type');

            $table->text('value_type');
            $table->text('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_properties_heroes');
    }
}
