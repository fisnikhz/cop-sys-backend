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
        Schema::create('Incidents', function (Blueprint $table) {

            $table->uuid('incident_id');
            $table->text('incident_type');
            $table->text('description');
            $table->uuid('location');
            $table->timestamp('report_date_time');
            $table->uuid('reporter_id');
            $table->json('participants_id')->nullable();
            $table->json('vehicles_number')->nullable();
            $table->primary('incident_id');
            $table->foreign('reporter_id')->references('personnel_id')->on('Personnels');
            $table->foreign('location')->references('location_id')->on('Locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Incidents');
    }
};
