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

            $table->uuid('attendance_id',36);
            $table->uuid('personnel_id',36);
            $table->date('attendance_date');
            $table->datetime('entry_time');
            $table->datetime('exit_time');
            $table->boolean('missed_entry')->default('false');
            $table->foreign('personnel_id')->references('personnel_id')->on('Personnels');
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
