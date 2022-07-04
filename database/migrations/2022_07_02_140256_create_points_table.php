<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('amount');
            $table->boolean('used')->default(false);
            $table->boolean('expired')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_points')->default(0);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('points_redeemed')->default(false);
        });

        Schema::table('return_requests', function (Blueprint $table) {
            $table->unsignedInteger('points')->nullable();
        });

        Schema::table('order_variation', function (Blueprint $table) {
            $table->unsignedInteger('points')->nullable();
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
            $table->dropColumn('points');
        });

        Schema::table('return_requests', function (Blueprint $table) {
            $table->dropColumn('points');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('points_redeemed');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('total_points');
        });

        Schema::dropIfExists('points');
    }
}
