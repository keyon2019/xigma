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
            $table->foreignId('address_id');
            $table->unsignedInteger('shipping_method');
            $table->unsignedInteger('cost_preference');
            $table->unsignedInteger('order_status');
            $table->boolean('paid')->default(false);
            $table->unsignedInteger('total');

            $table->timestamps();
        });

        Schema::create('order_variation', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained();
            $table->foreignId('variation_id')->constrained();
            $table->unsignedInteger('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_variation');
        Schema::dropIfExists('orders');
    }
}
