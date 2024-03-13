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
        Schema::create('Department_Personnels', function (Blueprint $table) {

            $table->uuid('department_id');
            $table->uuid('personnel_id');
            $table->foreign('department_id')->references('id')->on('Departments');
            $table->foreign('personnel_id')->references('personnel_id')->on('Personnels');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Department_Personnels');
    }
};
