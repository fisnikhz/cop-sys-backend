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
        Schema::create('Emergency_Calls', function (Blueprint $table) {

            $table->uuid('call_id')->primary();
            $table->text('caller_name');
            $table->text('phone_number');
            $table->text('incident_type');
            $table->foreignUuid('location')->constrained('Locations','location_id')->nullable();
            $table->datetime('time');
            $table->foreignUuid('responder')->constrained('Personnels','personnel_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Emergency_Calls');
    }
};
