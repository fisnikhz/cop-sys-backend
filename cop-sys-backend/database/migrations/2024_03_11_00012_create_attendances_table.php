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
        Schema::create('Attendances', function (Blueprint $table) {

            $table->uuid('attendance_id')->primary();
            $table->foreignUuid('personnel_id')->constrained('Personnels','personnel_id');;
            $table->date('attendance_date');
            $table->datetime('entry_time');
            $table->datetime('exit_time');
            $table->boolean('missed_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Attendances');
    }
};
