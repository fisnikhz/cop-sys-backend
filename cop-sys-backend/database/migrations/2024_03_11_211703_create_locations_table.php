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
        Schema::create('Locations', function (Blueprint $table) {
            $table->uuid('location_id');
            $table->bigInteger('name');
            $table->text('address');
            $table->text('longitude');
            $table->text('latitude');
            $table->double('radius');
            $table->primary(['location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Locations');
    }
};
