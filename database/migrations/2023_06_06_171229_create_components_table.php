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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table-> string('component_name');
            $table->string('component_type');
            $table->float('component_price');
            $table->string('component_address');
            $table->float('component_minimal_quantity');
            $table-> float('component_available_quantity');
            $table->string('component_unit_of_measurement');
            $table->date('component_appointment_end_date_reminder');
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
        Schema::dropIfExists('components');
    }
};
