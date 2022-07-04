<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('code', 10)->unique();
            $table->unsignedInteger('points');
            $table->unsignedInteger('discount');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('discount')->nullable();
            $table->string('coupon', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('discount');
            $table->dropColumn('coupon');
        });
        Schema::dropIfExists('coupons');
    }
}
