<?php namespace {namespace};

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class {className} extends Migration
{
    public function up()
    {
        Schema::create('{tableNamePrefix}', function (Blueprint $table) : void {
            // TODO
        });
    }

    public function down()
    {
        Schema::dropIfExists('{tableNamePrefix}');
    }
}
