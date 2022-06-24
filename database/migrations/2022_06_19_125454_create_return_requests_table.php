<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable();
        });

        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reason');
            $table->unsignedInteger('enquiry');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('discount');
            $table->unsignedInteger('price');
            $table->text('images');
            $table->text('elaboration');
            $table->unsignedInteger('technical_status')->nullable();
            $table->text('technical_comment')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->string('receiver_number')->nullable();
            $table->string('receiver_name')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->unsignedInteger('gateway')->nullable();
            $table->unsignedBigInteger('reference_number')->nullable();
            $table->unsignedInteger('shipping_method')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->unsignedBigInteger('shipping_code')->nullable();
            $table->timestamps();

            $table->foreignId('variation_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('technician_id')->nullable()->constrained('users', 'id');
            $table->foreignId('address_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_requests');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });
    }
}
