<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMysettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mysettings', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('about');
            $table->longText('favorite_music');
            $table->longText('hobbies');
            $table->string('url_twitter');
            $table->string('url_facebook');
            $table->integer('users_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mysettings');
    }
}
