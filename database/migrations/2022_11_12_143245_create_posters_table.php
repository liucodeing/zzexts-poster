<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('zzexts-poster.database.poster_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo_src', 255);
            $table->string('mix_src', 255);
            $table->string('name', 255);
            $table->integer('sort', 11);
            $table->json('path');
            $table->dateTime('disabled_at');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posters');
    }
}
