<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('MERCHANT_ID')->nullable();
            $table->string('AMOUNT')->nullable();
            $table->string('intid')->nullable();
            $table->string('MERCHANT_ORDER_ID')->nullable();
            $table->string('P_EMAIL')->nullable();
            $table->string('CUR_ID')->nullable();
            $table->string('SIGN')->nullable();
            $table->boolean('success')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('payment_orders');
    }
}
