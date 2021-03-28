<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayerDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payer_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("payer_id");
            $table->foreign("payer_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("job_title");
            $table->text("prev_work");
            $table->longText("bio");
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
        Schema::dropIfExists('payer_data');
    }
}
