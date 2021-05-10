<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBiginteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedBiginteger('user_service_id');
            $table->foreign('user_service_id')->references('id')->on('user_services')->onDelete('cascade');
            $table->unsignedBiginteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('charge_id')->nullable();
            $table->string('source_id')->nullable();
            // paid the client paid to work with this service
            // failed the payment faild
            // processign the freelancer start to work with this service.
            // cancelled  the freelancer cancelled it.
            // done the freelancer mark it as done.
            // received the client mark it as done.
            $table->enum('status',['pending','paid','failed','processing','cancelled','done','received']);
            $table->double('price');
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
        Schema::dropIfExists('orders');
    }
}
