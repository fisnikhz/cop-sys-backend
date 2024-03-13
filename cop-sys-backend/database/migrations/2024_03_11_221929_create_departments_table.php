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

            $table->uuid('department_id');
            $table->text('department_name');
            $table->text('department_logo');
            $table->text('description');
            $table->uuid('hq_location');
            $table->primary('department_id');
            $table->foreign('hq_location')->references('location_id')->on('Locations');
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
