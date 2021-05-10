<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_items', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id');
            $table->unsignedBiginteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBiginteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBiginteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedBiginteger('user_service_id');
            $table->foreign('user_service_id')->references('id')->on('user_services')->onDelete('cascade');
            $table->string('service_title');
            $table->string('system_fees');
            $table->string('system_fees_percent');
            $table->string('service_price');
            $table->string('service_total_amount');
            $table->unsignedBiginteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->enum('status',['paid','pending','unpaid'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_items');
    }
}
