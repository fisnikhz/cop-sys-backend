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

            $table->uuid('user_id');
            $table->uuid('conversation_id');
            $table->foreign('user_id')->references('user_id')->on('Users');
            $table->foreign('conversation_id')->references('conversation_id')->on('Conversations');
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
