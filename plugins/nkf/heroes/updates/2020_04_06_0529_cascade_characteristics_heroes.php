<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableCascadeCharacteristicsHeroes extends Migration
{
    public function up()
    {
        Schema::table('nkf_heroes_properties_heroes', function (Blueprint $table) : void {
            $table->foreign('hero_id')->on('nkf_heroes_heroes')->references('id')->onDelete('cascade');
        });
    }

    public function down()
    {
    }
}
