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
        Schema::create('Vehicles', function (Blueprint $table) {

            $table->uuid('vehicle_id')->primary();
            $table->text('vehicle_registration');
            $table->text('manufacture_name');
            $table->text('serie');
            $table->text('type');
            $table->date('produced_date');
            $table->date('purchased_date');
            $table->date('registration_date');
            $table->foreignUuid('designated_driver')->constrained('Personnels','personnel_id');
            $table->text('car_picture');
            $table->foreignUuid('car_location')->constrained('Locations','location_id');
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
