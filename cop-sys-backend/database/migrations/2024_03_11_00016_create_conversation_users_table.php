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
        Schema::create('Conversation_Users', function (Blueprint $table) {

            $table->foreignUuid('sender_id')->constrained('Users','user_id');
            $table->foreignUuid('conversation_id')->constrained('Conversations','conversation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Conversation_Users');
    }
};
