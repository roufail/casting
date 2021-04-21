<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordRecoveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_recovery', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            // $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->enum("user_type",["client","payer"]);
            $table->integer("code")->length(11);
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
        Schema::dropIfExists('password_recovery');
    }
}
