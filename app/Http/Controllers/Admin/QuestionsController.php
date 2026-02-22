<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua soal beserta relasi quiz, urut terbaru
        $questions = Questions::with('quiz')->latest('created_at')->get();
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizzes = Quiz::all();
        return view('admin.questions.create', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'score' => 'required|numeric|min:1', // validasi score
        ]);

        Questions::create([
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'score' => $request->score, // simpan score
        ]);

        return redirect()->route('questions.index')
                         ->with('success', 'Soal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Questions::with('quiz')->findOrFail($id);
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Questions::findOrFail($id);
        $quizzes = Quiz::all();

        return view('admin.questions.edit', compact('question', 'quizzes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'score' => 'required|numeric|min:1', // validasi score
        ]);

        $question = Questions::findOrFail($id);

        $question->update([
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'score' => $request->score, // update score
        ]);

        return redirect()->route('questions.index')
                         ->with('success', 'Soal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Questions::findOrFail($id);
        $question->delete();

        return redirect()->route('questions.index')
                         ->with('success', 'Soal berhasil dihapus');
    }
}
