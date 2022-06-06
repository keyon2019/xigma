<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeItemsFromUniqueBasedToQuantityBased extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->foreignId('variation_id')->constrained();
            $table->foreignId('retailer_id')->nullable()->constrained();
            $table->unsignedBigInteger('quantity')->default(0);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('sold');
            $table->dropColumn('moving');
            $table->dropColumn('barcode');
            $table->dropColumn('discount');
            $table->dropForeign(['shipping_id']);
            $table->dropColumn('shipping_id');
            $table->renameColumn('stock_id', 'retailer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('sold')->default(false);
            $table->boolean('moving')->default(false);
            $table->string('barcode')->index();
            $table->renameColumn('retailer_id', 'stock_id');
            $table->unsignedInteger('discount')->nullable();
            $table->foreignId('shipping_id')->nullable()->constrained();
        });

        Schema::dropIfExists('stocks');
    }
}
