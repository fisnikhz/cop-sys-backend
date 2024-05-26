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
            $table->foreignUuid('vehicle')->nullable()->constrained('Vehicle','vehicle_id');
            $table->foreignUuid('person')->nullable()->constrained('Person','person_id');
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
