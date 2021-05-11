<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('splash')->index()->nullable();
            $table->timestamps();

            $table->foreign('splash')->references('id')->on('pictures')->onDelete('set null');
        });

        Schema::create('vehicle_variation', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->index();
            $table->unsignedBigInteger('variation_id')->index();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_variation');
        Schema::dropIfExists('vehicles');
    }
}
