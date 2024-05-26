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
        Schema::table('Vehicle', function (Blueprint $table) {
            // Making the car_location column nullable
            $table->uuid('car_location')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Vehicle', function (Blueprint $table) {
            // Reverting the car_location column to not nullable
            $table->uuid('car_location')->nullable(false)->change();
        });
    }
};
