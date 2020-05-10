<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableRenameCharacteristicsHeroes extends Migration
{
    public function up()
    {
        Schema::rename('nkf_heroes_properties_heroes', 'nkf_heroes_characteristics_heroes');
    }

    public function down()
    {
        Schema::rename('nkf_heroes_characteristics_heroes', 'nkf_heroes_properties_heroes');
    }
}
