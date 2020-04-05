<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableUpdatePropertiesHeroes extends Migration
{
    public function up()
    {
        Schema::table('nkf_heroes_properties_heroes', function (Blueprint $table) : void {
            $table->dropColumn(['property_type', 'value_type']);
            $table->renameColumn('property_id', 'characteristic_id')->change();
            $table->unsignedInteger('value')->change();

            $table->foreign('characteristic_id')->on('nkf_heroes_characteristics')->references('id');

            $table->primary(['hero_id', 'characteristic_id']);
        });
    }

    public function down()
    {
        Schema::table('nkf_heroes_properties_heroes', function (Blueprint $table) : void {
            $table->dropPrimary(['hero_id', 'characteristic_id']);
            $table->dropForeign(['characteristic_id']);
            $table->text('value')->change();
            $table->renameColumn('characteristic_id', 'property_id')->change();
            $table->text('property_type');
            $table->text('value_type');
        });
    }
}
