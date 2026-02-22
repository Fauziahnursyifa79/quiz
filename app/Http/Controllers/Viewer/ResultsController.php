<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\Results;
use App\Models\Questions;
use App\Models\User_answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function index()
    {
        $results = Results::with('quiz')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('view.results.index', compact('results'));
    }

    /**
     * FUNGSI STORE: Inilah yang tadi hilang dan menyebabkan error.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answer'  => 'required|array',
        ]);

        return DB::transaction(function () use ($request) {
            $quizId = $request->quiz_id;
            $userAnswers = $request->answer; // Format: [question_id => "a"]

            $correctCount = 0;
            $totalQuestions = count($userAnswers);

            // 2. Buat data Result (Induk) terlebih dahulu
            $result = Results::create([
                'user_id'         => Auth::id(),
                'quiz_id'         => $quizId,
                'score'           => 0, // Akan diupdate di bawah
                'total_questions' => $totalQuestions,
                'correct_answers' => 0,
                'is_passed'       => false,
            ]);

            // 3. Simpan setiap jawaban ke tabel user_answers dan hitung benar/salah
            foreach ($userAnswers as $questionId => $selectedOption) {
                $question = Questions::find($questionId);

                // Cek jawaban (case insensitive)
                $isCorrect = (strtolower($selectedOption) === strtolower($question->correct_answer));

                if ($isCorrect) {
                    $correctCount++;
                }

                User_answer::create([
                    'result_id'       => $result->id,
                    'question_id'     => $questionId,
                    'selected_answer' => $selectedOption,
                    'is_correct'      => $isCorrect,
                ]);
            }

            // 4. Hitung skor akhir dan update data Result
            $finalScore = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;

            $result->update([
                'score'           => $finalScore,
                'correct_answers' => $correctCount,
                'is_passed'       => $finalScore >= 70, // Standar lulus 70
            ]);

            // 5. Arahkan ke halaman hasil yang baru saja dibuat
            return redirect()->route('result.show', $result->id)
                             ->with('success', 'Quiz berhasil diselesaikan!');
        });
    }

    public function show(string $id)
    {
        $result = Results::with(['quiz', 'user'])->findOrFail($id);

        if ($result->user_id !== Auth::id()) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT ROLES.');
        }

        return view('view.results.show', compact('result'));
    }
}
