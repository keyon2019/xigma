<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('special_price')->nullable();
            $table->unsignedBigInteger('delivery_cost');
            $table->boolean('is_huge')->default(false);
            $table->boolean('preorderable')->default(false);
            $table->unsignedBigInteger('daily_production_capacity')->nullable();
            $table->boolean('onesie')->default(false);
            $table->unsignedBigInteger('splash')->index()->nullable();
            $table->timestamp('special_price_expiration')->nullable();


            $table->foreign('splash')->references('id')->on('pictures')->onDelete('set null');
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
        Schema::dropIfExists('products');
    }
}
