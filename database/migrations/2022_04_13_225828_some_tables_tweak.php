<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SomeTablesTweak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_variation', function (Blueprint $table) {
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('discount')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('receiver')->nullable();
            $table->string('receiver_number')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->unique()->index()->nullable();
            $table->string('email')->nullable()->change();
            $table->string('birthday')->nullable();
            $table->string('telephone')->nullable();
            $table->string('emergency_mobile')->nullable();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('discount')->nullable();
        });

        Schema::table('invoice_variation', function (Blueprint $table) {
            $table->unsignedInteger('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_variation', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('discount');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('receiver');
            $table->dropColumn('receiver_number');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mobile');
            $table->string('email')->nullable(false)->change();
            $table->dropColumn('birthday');
            $table->dropColumn('telephone');
            $table->dropColumn('emergency_mobile');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('discount');
        });

        Schema::table('invoice_variation', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
}
