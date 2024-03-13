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

            $table->uuid('call_id');
            $table->text('caller_name');
            $table->text('phone_number');
            $table->text('incident_type');
            $table->uuid('location')->nullable();
            $table->datetime('time');
            $table->uuid('responder');
            $table->primary('call_id');
            $table->foreign('location')->references('location_id')->on('Locations');
            $table->foreign('responder')->references('personnel_id')->on('Personnels');

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
