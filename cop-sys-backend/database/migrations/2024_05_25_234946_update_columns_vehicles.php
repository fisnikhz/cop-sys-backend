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
        Schema::table('Vehicle', function (Blueprint $table) {

            $table->date('purchased_date')->nullable()->change();
            $table->date('registration_date')->nullable()->change();
            $table->foreignUuid('designated_driver')->nullable()->change();
            $table->text('car_picture')->nullable()->change();
            $table->foreignUuid('car_location')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
