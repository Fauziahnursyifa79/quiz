<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Questions; // Pastikan Model Soal di-import

class QuizController extends Controller
{
    /**
     * Menampilkan daftar semua quiz (Dashboard Quiz)
     */
    public function index()
    {
        // Mengambil semua quiz yang aktif dan relasi materinya
        $quizzes = Quiz::with('materi')->where('is_active', 1)->latest()->get();

        // Pastikan folder view-nya adalah view/quiz/index.blade.php
        return view('view.Quiz.index', compact('quizzes'));
    }

    /**
     * Menampilkan soal-soal di dalam quiz yang dipilih
     */
    public function show(string $id)
    {
        // 1. Cari Quiz-nya
        // 2. Load 'questions' (relasi hasMany di model Quiz)
        $quiz = Quiz::with('questions')->where('is_active', 1)->findOrFail($id);

        // Arahkan ke blade pengerjaan soal
        // Kita gunakan folder view/Questions/show sesuai keinginanmu sebelumnya
        return view('view.Quiz.show', compact('quiz'));
    }
}
