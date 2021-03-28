<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayerWorkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payer_work_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("payer_id");
            $table->foreign("payer_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("image_url");
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
        Schema::dropIfExists('payer_work_images');
    }
}
