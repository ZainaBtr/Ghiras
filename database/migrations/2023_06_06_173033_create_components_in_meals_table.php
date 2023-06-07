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
        Schema::create('components_in_meals', function (Blueprint $table) {
            $table->id('component_in_meal_id');
            $table->string('meal_name');
            $table->foreign('meal_name')->references('meal_name')->on('meals')->cascadeOnDelete();
            $table->foreignId('component_id')->default(1)->constrained('components')->cascadeOnDelete();
            $table->float('component_in_meal_quantity');
            $table->string('component_in_meal_unit_of_measurement');
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
        Schema::dropIfExists('components_in_meals');
    }
};
