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

            $table->uuid('incident_id')->primary();
            $table->text('incident_type');
            $table->text('description');
            $table->foreignUuid('location')->constrained('Locations','location_id')->nullable();
            $table->timestamp('report_date_time');
            $table->foreignUuid('reporter_id')->constrained('Personnels','personnel_id');
            $table->json('participants_id')->nullable();
            $table->json('vehicles_number')->nullable();
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
