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
        //
        Schema::table('Attendances', function (Blueprint $table) {
            // Making the car_location column nullable
            $table->uuid('exit_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('Attendances', function (Blueprint $table) {
            // Making the car_location column nullable
            $table->uuid('exit_time')->nullable()->change();
        });
    }
};
