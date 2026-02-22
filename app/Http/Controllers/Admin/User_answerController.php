<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_answer;
use App\Models\Results;
use App\Models\Questions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User_answerController extends Controller
{
    public function index()
    {
        // Mengambil data dengan Eager Loading agar tidak berat saat loading halaman
        $answers = User_answer::with(['result.user', 'result.quiz', 'question'])
            ->latest()
            ->get();

        return view('admin.user_admin.index', compact('answers'));
    }

    public function create()
    {
        $questions = Questions::all();
        return view('admin.user_admin.create', compact('questions'));
    }

    public function store(Request $request)
    {
        // Validasi login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'question_id'     => 'required|exists:questions,id',
            'selected_answer' => 'required|in:a,b,c,d',
        ]);

        $question = Questions::findOrFail($request->question_id);

        return DB::transaction(function () use ($request, $question) {
            // 1. Ambil atau buat data Result (Induk)
            $result = Results::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'quiz_id' => $question->quiz_id
                ],
                [
                    'score' => 0,
                    'total_questions' => 0,
                    'correct_answers' => 0,
                    'is_passed' => false
                ]
            );

            // 2. Cek apakah jawaban user benar
            $is_correct = (strtolower($request->selected_answer) === strtolower($question->correct_answer));

            // 3. SIMPAN/UPDATE ke tabel user_answers (Agar muncul di list Admin)
            User_answer::updateOrCreate(
                [
                    'result_id'   => $result->id,
                    'question_id' => $question->id,
                ],
                [
                    'selected_answer' => $request->selected_answer,
                    'is_correct'      => $is_correct,
                ]
            );

            // 4. Hitung ulang Score di tabel results agar data sinkron
            $answers = User_answer::where('result_id', $result->id)->get();
            $correctCount = $answers->where('is_correct', true)->count();
            $totalQuestionsInQuiz = Questions::where('quiz_id', $question->quiz_id)->count();

            // Perhitungan skor (misal: benar / total soal * 100)
            $score = ($totalQuestionsInQuiz > 0) ? ($correctCount / $totalQuestionsInQuiz) * 100 : 0;

            $result->update([
                'score'           => $score,
                'total_questions' => $totalQuestionsInQuiz,
                'correct_answers' => $correctCount,
                'is_passed'       => $score >= 70, // Standar lulus 70
            ]);

            return redirect()->back()->with('success', 'Jawaban berhasil disimpan!');
        });
    }

    public function show(string $id)
    {
        $answer = User_answer::with(['result.user', 'question'])->findOrFail($id);
        return view('admin.user_admin.show', compact('answer'));
    }

    public function edit(string $id)
    {
        $answer = User_answer::findOrFail($id);
        $questions = Questions::all();
        return view('admin.user_admin.edit', compact('answer', 'questions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'question_id'     => 'required|exists:questions,id',
            'selected_answer' => 'required|in:a,b,c,d',
            'is_correct'      => 'required|boolean',
        ]);

        $answer = User_answer::findOrFail($id);
        $answer->update($request->only(['question_id', 'selected_answer', 'is_correct']));

        return redirect()->route('user_answer.index')->with('success', 'Jawaban berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $answer = User_answer::findOrFail($id);
        $answer->delete();
        return redirect()->route('user_answer.index')->with('success', 'Jawaban berhasil dihapus!');
    }
}
