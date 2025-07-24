<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');

            // If the post is deleted, delete its comments. This is correct.
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            // If the user is deleted, delete their comments. This is the simplest approach.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Must be plural to match the table name
        Schema::dropIfExists('comments');
    }
};