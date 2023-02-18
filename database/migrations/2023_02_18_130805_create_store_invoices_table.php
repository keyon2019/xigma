<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retailer_id')->constrained();
            $table->timestamps();
        });

        Schema::create('store_invoice_variation', function (Blueprint $table) {
            $table->foreignId('variation_id')->constrained();
            $table->foreignId('store_invoice_id')->constrained();

            $table->unsignedBigInteger('quantity')->default(1);
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_invoice_variation');
        Schema::dropIfExists('store_invoices');
    }
}
