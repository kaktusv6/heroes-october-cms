<?php namespace Nkf\Heroes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class BuilderTableCreateUsersToken extends Migration
{
    public function up()
    {
        Schema::create('nkf_heroes_user_tokens', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('token', 10);
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->on('nkf_heroes_users')->references('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nkf_heroes_user_tokens');
    }
}
