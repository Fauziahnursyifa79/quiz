<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Materi;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('materi')->latest()->get();
        return view('admin.quiz.index', compact('quizzes'));
    }

    public function create()
    {
        $materis = Materi::all();
        return view('admin.quiz.create', compact('materis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materi_id'     => 'required|exists:materis,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'time_limit'    => 'nullable|integer|min:1',
            'passing_score' => 'nullable|integer|min:0',
            'is_active'     => 'required|boolean',
        ]);

        Quiz::create([
            'materi_id'     => $request->materi_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'time_limit'    => $request->time_limit,
            'passing_score' => $request->passing_score ?? 0,
            'is_active'     => $request->is_active,
        ]);

        return redirect()->route('quiz.index')
            ->with('success', 'Quiz berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $quiz = Quiz::with('materi')->findOrFail($id);
        return view('admin.quiz.show', compact('quiz'));
    }

    public function edit(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $materis = Materi::all();
        return view('admin.quiz.edit', compact('quiz', 'materis'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'materi_id'     => 'required|exists:materis,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'time_limit'    => 'nullable|integer|min:1',
            'passing_score' => 'nullable|integer|min:0',
            'is_active'     => 'required|boolean',
        ]);

        $quiz = Quiz::findOrFail($id);

        $quiz->update([
            'materi_id'     => $request->materi_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'time_limit'    => $request->time_limit,
            'passing_score' => $request->passing_score ?? 0,
            'is_active'     => $request->is_active,
        ]);

        return redirect()->route('quiz.index')
            ->with('success', 'Quiz berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('quiz.index')
            ->with('success', 'Quiz berhasil dihapus!');
    }
}
