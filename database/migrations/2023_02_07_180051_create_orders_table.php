<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('total_quantity')->unsigned();
            $table->bigInteger('total_price')->unsigned();
            $table->string('note', 255)->nullable();
            $table->string('phone', 20);
            $table->string('address', 255);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('token', 255)->nullable();
            $table->bigInteger('payment_method')->unsigned()->nullable();
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
};
