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

            $table->uuid('user_id');
            $table->text('name');
            $table->text('email');
            $table->text('salt');
            $table->text('password');
            $table->text('username');
            $table->text('device_id');
            $table->text('profile_image');
            $table->uuid('role');
            $table->uuid('personnel_id')->nullable();
            $table->primary('user_id');
            $table->timestamps();
            $table->foreign('role')->references('role_id')->on('Roles');
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
