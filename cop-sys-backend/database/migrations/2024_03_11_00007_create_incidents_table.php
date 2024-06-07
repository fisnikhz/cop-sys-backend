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
            $table->text('title')->nullable();
            $table->text('incident_cause')->nullable();
            $table->text('incident_type')->nullable();
            $table->text('description');
            $table->date('reported_date')->nullable();
            $table->foreignUuid('reporter_id')->constrained('Personnels','personnel_id');
            $table->foreignUuid('participants_id')->constrained('Person','personal_number');
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
