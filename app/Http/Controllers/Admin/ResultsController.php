<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Results;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan semua hasil (admin bisa lihat semua)
        $results = Results::with(['user', 'quiz'])->latest()->get();
        return view('admin.results.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua quiz
        $quizzes = Quiz::all();

        // User yang login akan otomatis disimpan di store
        return view('admin.results.create', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id'          => 'required|exists:quizzes,id',
            'score'            => 'required|integer|min:0',
            'total_questions'  => 'required|integer|min:1',
            'correct_answers'  => 'required|integer|min:0',
            'is_passed'        => 'required|boolean',
        ]);

        Results::create([
            'user_id'          => Auth::id(), // Ambil user yang login
            'quiz_id'          => $request->quiz_id,
            'score'            => $request->score,
            'total_questions'  => $request->total_questions,
            'correct_answers'  => $request->correct_answers,
            'is_passed'        => $request->is_passed,
        ]);

        return redirect()->route('results.index')
                         ->with('success', 'Hasil quiz berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Results::with(['user', 'quiz'])->findOrFail($id);
        return view('admin.results.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $result = Results::findOrFail($id);
        $quizzes = Quiz::all();

        return view('admin.results.edit', compact('result', 'quizzes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quiz_id'          => 'required|exists:quizzes,id',
            'score'            => 'required|integer|min:0',
            'total_questions'  => 'required|integer|min:1',
            'correct_answers'  => 'required|integer|min:0',
            'is_passed'        => 'required|boolean',
        ]);

        $result = Results::findOrFail($id);

        $result->update([
            'user_id'          => Auth::id(), // tetap dari user login
            'quiz_id'          => $request->quiz_id,
            'score'            => $request->score,
            'total_questions'  => $request->total_questions,
            'correct_answers'  => $request->correct_answers,
            'is_passed'        => $request->is_passed,
        ]);

        return redirect()->route('results.index')
                         ->with('success', 'Hasil quiz berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Results::findOrFail($id);
        $result->delete();

        return redirect()->route('results.index')
                         ->with('success', 'Hasil quiz berhasil dihapus!');
    }
}
