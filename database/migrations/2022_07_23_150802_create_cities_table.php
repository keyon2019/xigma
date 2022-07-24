<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained();
            $table->string('name');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('province');
            $table->dropColumn('city');

            $table->foreignId('province_id')->nullable()->constrained();
            $table->foreignId('city_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropColumn('province_id');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');

            $table->string('province')->nullable();
            $table->string('city')->nullable();
        });

        Schema::dropIfExists('cities');
    }
}
