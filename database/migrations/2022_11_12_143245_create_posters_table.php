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
        $connection = config('zzexts-poster.database.connection') ?: config('database.default');

        $table = config('zzexts-poster.database.poster_table', 'posters');

        Schema::connection($connection)->create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo_src', 255)->nullable();
            $table->string('mix_src', 255)->nullable();
            $table->string('name', 255);
            $table->integer('sort')->default(0);
            $table->json('path')->nullable();;
            $table->dateTime('disabled_at')->nullable();;
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();;
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('zzexts-poster.database.connection') ?: config('database.default');

        $table = config('zzexts-poster.database.poster_table', 'posters');

        Schema::connection($connection)->dropIfExists($table);
    }

}

