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
        Schema::create('Users', function (Blueprint $table) {

            $table->uuid('user_id')->primary();
            $table->text('name');
            $table->text('email');
            $table->text('password');
            $table->text('salt');
            $table->text('username');
            $table->text('device_id');
            $table->text('profile_image')->nullable();
            $table->foreignId('role')->nullable()->constrained('Roles','role_id');
            $table->uuid('personnel_id')->nullable();
            $table->timestamps();
            $table->foreign('personnel_id')->references('personnel_id')->on('Personnels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Users');
    }
};
