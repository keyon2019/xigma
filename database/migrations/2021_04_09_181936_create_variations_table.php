<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('name')->nullable();
            $table->string('sku')->index()->nullable();
            $table->unsignedBigInteger('splash')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('special_price')->nullable();
            $table->unsignedBigInteger('points')->nullable();
            $table->timestamp('special_price_expiration')->nullable();
            $table->timestamps();

            $table->foreign('splash')->references('id')->on('pictures')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variations');
    }
}
