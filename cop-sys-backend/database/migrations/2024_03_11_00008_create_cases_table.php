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
        Schema::create('Cases', function (Blueprint $table) {

            $table->uuid('case_id')->primary();
            $table->text('status');
            $table->datetime('open_date');
            $table->datetime('close_date')->nullable();
            $table->foreignUuid('investigator_id')->constrained('Personnels','personnel_id');;
            $table->json('incidents_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cases');
    }
};
