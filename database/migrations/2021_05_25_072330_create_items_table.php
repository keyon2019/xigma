<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variation_id')->index();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('stock_id')->nullable()->index();
            $table->boolean('sold')->default(false);
            $table->boolean('moving')->default(false);
            $table->string('barcode')->unique()->index();
            $table->timestamps();

            $table->foreign('variation_id')->references('id')->on('variations');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('stock_id')->references('id')->on('retailers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
