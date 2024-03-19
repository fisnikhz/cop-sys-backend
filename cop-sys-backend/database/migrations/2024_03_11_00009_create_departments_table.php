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
        Schema::create('Departments', function (Blueprint $table) {

            $table->uuid('department_id')->primary();
            $table->text('department_name');
            $table->text('department_logo');
            $table->text('description');
            $table->foreignUuid('hq_location')->constrained('Locations','location_id');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Departments');
    }
};
