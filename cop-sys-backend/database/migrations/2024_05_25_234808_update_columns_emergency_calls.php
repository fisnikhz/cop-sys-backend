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
        Schema::table('Emergency_Calls', function (Blueprint $table) {

            $table->text('caller_name')->nullable()->change();
            $table->datetime('time')->nullable()->change();
            $table->foreignUuid('responder')->nullable()->change();
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
