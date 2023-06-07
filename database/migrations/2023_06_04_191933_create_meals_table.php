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
        Schema::create('meals', function (Blueprint $table) {
            $table -> string('meal_name')->primary()->unique();
            $table->string('category_name');
            $table->foreign('category_name')->references('category_name')->on('categories')->cascadeOnDelete();
            $table -> string('meal_type');
            $table -> float('meal_price');
            $table -> float('meal_price_show');
            $table -> Integer('meal_ready_quantity');
            $table->string('meal_picture');
            $table->text('meal_description');
            $table->boolean('meal_In_menu');
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
        Schema::dropIfExists('meals');
    }
};
