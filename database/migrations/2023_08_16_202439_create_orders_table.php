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
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users');
            $table->date('date_order'); // التاريخ الذي تم فيه ارسال الطلب
            $table->time('time_order'); // الوقت الذي تم فيه ارسال الطلب
            $table->date('order_date'); // التاريخ الذي يرسم المستخد استلام الطلب فيه
            $table->time('order_time'); // الوقت الذي يريد المستخد استلام الطلب فيه
            $table->string('order_state')->default('not sent');
            $table->float('order_cost')->default(0);
            $table->integer('order_discount_percent')->default(0);
            $table->float('order_total_price');
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
