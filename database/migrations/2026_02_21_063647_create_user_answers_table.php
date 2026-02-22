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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('result_id')
                  ->constrained('results')
                  ->onDelete('cascade');

            $table->foreignId('question_id')
                  ->constrained('questions')
                  ->onDelete('cascade');

            $table->enum('selected_answer', ['a', 'b', 'c', 'd']); // Jawaban yang dipilih user
            $table->boolean('is_correct'); // Apakah benar atau salah

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
