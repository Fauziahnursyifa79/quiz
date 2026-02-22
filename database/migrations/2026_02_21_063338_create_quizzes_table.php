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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')
                  ->constrained('materis')
                  ->onDelete('cascade');

            $table->string('title'); // Judul kuis
            $table->text('description')->nullable(); // Deskripsi kuis
            $table->integer('time_limit')->nullable(); // Batas waktu (menit)
            $table->integer('passing_score')->default(0); // Nilai minimal lulus
            $table->boolean('is_active')->default(true); // Status aktif/tidak

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
