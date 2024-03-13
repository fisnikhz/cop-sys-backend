<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Vehicle', function (Blueprint $table) {

            $table->uuid('vehicle_id');
            $table->text('vehicle_registration');
            $table->text('manufacture_name');
            $table->text('serie');
            $table->text('type');
            $table->date('produced_date');
            $table->date('purchased_date');
            $table->date('registration_date');
            $table->uuid('designated_driver',);
            $table->text('car_picture');
            $table->uuid('car_location');
            $table->primary('vehicle_id');
            $table->foreign('car_location')->references('location_id')->on('Locations');
            $table->foreign('designated_driver')->references('personnel_id')->on('Personnels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
