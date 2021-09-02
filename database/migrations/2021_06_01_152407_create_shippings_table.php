<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->unsignedInteger('method');
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->unsignedInteger('cost');
            $table->string('code')->nullable();
            $table->boolean('sailed')->default(false);
            $table->timestamp('sailed_at')->nullable();
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('retailers');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('shipping_id')->nullable()->constrained();
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
            $table->dropConstrainedForeignId('shipping_id');
        });
        Schema::dropIfExists('shippings');
    }
}
