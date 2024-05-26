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
        Schema::table('Personnels', function (Blueprint $table) {

            $table->text('rank')->nullable()->change();
            $table->text('badge_number')->nullable()->change();
            $table->date('hire_date')->nullable()->change();
            $table->text('profile_image')->nullable()->change();
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
