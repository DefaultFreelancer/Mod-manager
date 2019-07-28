<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameModRelationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_mod_relation', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('egg_id')->nullable();
            $table->foreign('egg_id')->references('id')->on('eggs')->onDelete('cascade');

            $table->unsignedInteger('mod_id')->nullable();
            $table->foreign('mod_id')->references('id')->on('mods')->onDelete('cascade');

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
        Schema::dropIfExists('mods');
    }
}
