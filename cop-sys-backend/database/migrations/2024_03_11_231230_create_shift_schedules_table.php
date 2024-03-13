<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('Shift_Schedules', function (Blueprint $table) {

            $table->uuid('schedule_id',);
            $table->uuid('personnel_id');
            $table->datetime('shift_start_time');
            $table->datetime('shift_end_time');
            $table->foreign('personnel_id')->references('personnel_id')->on('Personnels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Shift_Schedules');
    }
};
