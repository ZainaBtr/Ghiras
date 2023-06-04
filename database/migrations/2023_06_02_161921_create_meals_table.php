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
            $table-> id();
            $table->string('meal_name')->primary();
            $table->string('type');
            $table->float('price');
            $table->float('price_show');
            $table->integer('ready_quantity');
            $table->string('picture');
            $table->text('description');
            $table->boolean('In_menu');
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
