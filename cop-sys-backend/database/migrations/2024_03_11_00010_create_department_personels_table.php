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

            $table->foreignUuid('department_id')->constrained('Departments','department_id');
            $table->foreignUuid('personnel_id')->constrained('Personnels','personnel_id');;
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
