<?php declare(strict_types=1);

namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableCreateNkfHeroesUsers extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_users', function($table)
        {
            $table->increments('id');
            $table->string('login');
            $table->text('password');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nkf_heroes_users');
    }
}
