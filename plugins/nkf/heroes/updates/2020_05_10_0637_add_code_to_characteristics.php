<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableAddCodeToCharacteristics extends Migration
{
    public function up()
    {
        Schema::table('nkf_heroes_characteristics', function (Blueprint $table) : void {
            $table->string('slug')->after('title')->unique();
        });
    }

    public function down()
    {
        Schema::table('nkf_heroes_characteristics', function (Blueprint $table) : void {
            $table->dropColumn(['slug']);
        });
    }
}
