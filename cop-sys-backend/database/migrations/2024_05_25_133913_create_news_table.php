<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('news_id')->primary();
            $table->string('title');
            $table->text('content');
            $table->json('tags')->nullable();
            $table->uuid('created_by');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
