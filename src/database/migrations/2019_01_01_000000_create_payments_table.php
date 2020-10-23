<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('payment_id')->nullable();
            $table->string('payment_provider')->nullable();
            $table->string('payment_method')->nullable();
            $table->float('total');
            $table->string('item_model')->nullable();
            $table->unsignedBigInteger('item_model_id')->nullable();
            $table->string('user_model')->nullable();
            $table->unsignedBigInteger('user_model_id')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->string('callback')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
