<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Shop', function(Blueprint $table){
            $table->integer('cover_id',false,true)
                ->nullable()->change();
        });

        Schema::table('Menu', function(Blueprint $table){
            $table->integer('avatar_id',false,true)
                ->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
