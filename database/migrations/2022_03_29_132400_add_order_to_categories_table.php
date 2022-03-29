<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0);
            $table->boolean('show')->default(true);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('show')->default(true);
            $table->string('en_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('show');
            $table->dropColumn('order');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('show');
            $table->dropColumn('en_name');
        });
    }
}
