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
        Schema::create('Conversations', function (Blueprint $table) {

            $table->uuid('conversation_id');
            $table->text('conversation_name');
            $table->text('conversation_picture');
            $table->timestamps();
            $table->primary('conversation_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Conversations');
    }
};
