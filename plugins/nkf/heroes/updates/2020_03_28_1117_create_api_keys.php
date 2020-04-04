<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableCreateApiKeys extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_api_keys', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('api_key', 10)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_api_keys');
    }
}
