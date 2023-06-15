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
            $table->id();
            $table -> string('meal_name')->unique();
            $table->foreignId("category_id")->default(1)->constrained('categories')->cascadeOnDelete();
           // $table->foreignId("category_name")->default("starter")->constrained('categories')->cascadeOnDelete();
            $table -> string('meal_type');
            $table -> float('meal_price')->default(0);
            $table -> float('meal_price_show')->default(0);
            $table -> Integer('meal_ready_quantity');
            $table->string('meal_picture');
            $table->text('meal_description');
            $table->boolean('meal_In_menu')->default(false);
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
