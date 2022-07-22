<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowWideSplashToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('show_slider')->default(true);
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->string('mobile_picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('mobile_picture');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('show_slider');
        });
    }
}
