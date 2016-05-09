<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakecoffeeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Shop', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('phonenumber',20);
        });

        Schema::create('Menu', function(Blueprint $table){
            $table->increments('id');
            $table->integer('shopid')->unsigned();
            $table->string('name');
            $table->string('quantity');
            $table->integer('price');

            $table->foreign('shopid')
                ->references('id')
                ->on('Shop')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('Photo', function(Blueprint $table){
            $table->increments('id');
            $table->text('src');
        });

        Schema::table('Shop', function(Blueprint $table){
            $table->integer('cover_id')->unsigned();
            $table->foreign('cover_id')
                ->references('id')->on('Photo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('Menu', function(Blueprint $table){
            $table->integer('avatar_id')->unsigned();
            $table->foreign('avatar_id')
                ->references('id')->on('Photo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('Shop');
        Schema::dropIfExists('Menu');
        Schema::dropIfExists('Photo');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
