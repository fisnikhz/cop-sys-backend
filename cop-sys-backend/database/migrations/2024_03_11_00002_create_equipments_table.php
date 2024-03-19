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
        Schema::create('Equipments', function (Blueprint $table) {

            $table->uuid('equipment_id')->primary();
            $table->string('name');
            $table->integer('quantity');
            $table->string('description');
            $table->uuid('location_id');
            $table->foreign('location_id')->references('location_id')->on('Locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Equipments');
    }
};
