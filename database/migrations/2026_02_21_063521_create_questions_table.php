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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            // Relasi ke quiz
            $table->foreignId('quiz_id')
                  ->constrained('quizzes')
                  ->onDelete('cascade');

            $table->text('question'); // Isi pertanyaan

            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');

            $table->enum('correct_answer', ['a', 'b', 'c', 'd']); // Kunci jawaban

            $table->integer('score')->default(1); // Nilai tiap soal, default 1

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
