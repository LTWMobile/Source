<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Order', function(Blueprint $table){
            $table->increments('id');
            $table->integer('shop_id',false,true);
            $table->integer('table_id');
            $table->timestamps();

            $table->foreign('shop_id')
                ->references('id')->on('Shop')
                ->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('OrderDetail', function(Blueprint $table){
            $table->integer('order_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->integer('count')->default(1);

            $table->primary(['order_id', 'menu_id']);
            $table->foreign('order_id')
                ->references('id')->on('Order')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('menu_id')
                ->references('id')->on('Menu')
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('Order');
        Schema::dropIfExists('OrderDetail');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
