<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('Messages', function (Blueprint $table) {

            $table->uuid('message_id');
            $table->uuid('sender_id');
            $table->text('content');
            $table->text('type');
            $table->timestamps();
            $table->primary('message_id');
            $table->foreign('sender_id')->references('user_id')->on('Users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
