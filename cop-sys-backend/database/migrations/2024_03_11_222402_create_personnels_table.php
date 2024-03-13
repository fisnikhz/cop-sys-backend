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
        Schema::create('Personnels', function (Blueprint $table) {

            $table->uuid('personnel_id');
            $table->text('first_name');
            $table->text('last_name');
            $table->text('rank');
            $table->text('badge_number');
            $table->date('hire_date');
            $table->text('profile_image');
            $table->uuid('role');
            $table->primary('personnel_id');
            $table->foreign('role')->references('role_id')->on('Roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Personnels');
    }
};
