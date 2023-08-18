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
        Schema::create('component_bill_in_fridges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_id')->constrained('components')->cascadeOnDelete();
            $table->float('component_bill_purchase_quantity');
            $table->float('component_bill_purchase_price');
            $table->date('component_bill_purchase_date');
            $table->float('component_bill_consumption_quantity');
            $table->float('component_bill_waste_quantity');
            $table->float('component_bill_available');
            $table->date('component_bill_expiration_date');
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
        Schema::dropIfExists('component_bill_in_fridges');
    }
};
