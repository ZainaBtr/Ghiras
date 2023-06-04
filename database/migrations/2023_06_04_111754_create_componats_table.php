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
        Schema::create('componats', function (Blueprint $table) {
            $table-> dropPrimary('id');
            $table->string('component_name')->primary();
            $table->string('type');
            $table->float('price');
            $table->string('address');
            $table->float('minimal_quantity');
            $table->float('added_quantity');
            $table->float('available_quantity');
            $table->string('unit_of_measurement');
            $table->date('appointment_end_date_reminder');
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
        Schema::dropIfExists('componats');
    }
};
