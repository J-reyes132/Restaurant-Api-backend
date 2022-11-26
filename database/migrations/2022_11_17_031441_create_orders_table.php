<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignid('table_id')->unsigned()->index()->references('id')->on('tables');
            $table->date('order_date');
            $table->foreignId('customer_id')->unsigned()->index()->references('id')->on('customers');
            $table->foreignid('product_id')->nullable()->unsigned()->index()->references('id')->on('products');
            $table->foreignid('menu_id')->nullable()->unsigned()->index()->references('id')->on('menus');
            $table->integer('quantity');
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
        Schema::dropIfExists('orders');
    }
}
