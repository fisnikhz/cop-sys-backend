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
        Schema::create('Conversation_Message', function (Blueprint $table) {

            $table->uuid('conversation_id');
            $table->uuid('message_id');
            $table->foreign('conversation_id')->references('conversation_id')->on('Conversations');
            $table->foreign('message_id')->references('message_id')->on('Messages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Conversation_messages');
    }
};
