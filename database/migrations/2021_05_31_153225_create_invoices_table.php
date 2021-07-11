<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('total');
            $table->timestamps();
        });

        Schema::create('invoice_variation', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->index();
            $table->unsignedBigInteger('variation_id')->index();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_variation');
        Schema::dropIfExists('invoices');
    }
}
