<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnUrlOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('url_option', function (Blueprint $table) {
            //
        });

        Schema::table('images', function (Blueprint $table){
            $table->string('url_min');
            $table->string('url_original');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url_option', function (Blueprint $table) {
            //
        });
    }
}
