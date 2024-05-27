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
        Schema::create('Tickets', function (Blueprint $table) {
            $table->uuid('ticket_id')->primary();
            $table->text('description');
            $table->text('title');
            $table->foreignUuid('vehicle')->nullable()->constrained('Vehicles','vehicle_id');
            $table->string('person')->nullable();
            $table->foreign('person')->references('personnel_number')->on('Person');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
