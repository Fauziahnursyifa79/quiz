@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Edit Soal</h5>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-body">

                {{-- TAMPILKAN ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('questions.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- WAJIB UNTUK UPDATE --}}

                    {{-- Pilih Quiz --}}
                    <div class="mb-3">
                        <label class="form-label">Quiz *</label>
                        <select name="quiz_id" class="form-control" required>
                            <option value="">-- Pilih Quiz --</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}"
                                    {{ old('quiz_id', $question->quiz_id) == $quiz->id ? 'selected' : '' }}>
                                    {{ $quiz->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pertanyaan --}}
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan *</label>
                        <textarea name="question" class="form-control" rows="3" required>{{ old('question', $question->question) }}</textarea>
                    </div>

                    {{-- Opsi A --}}
                    <div class="mb-3">
                        <label class="form-label">Opsi A *</label>
                        <input type="text" name="option_a" class="form-control" value="{{ old('option_a', $question->option_a) }}" required>
                    </div>

                    {{-- Opsi B --}}
                    <div class="mb-3">
                        <label class="form-label">Opsi B *</label>
                        <input type="text" name="option_b" class="form-control" value="{{ old('option_b', $question->option_b) }}" required>
                    </div>

                    {{-- Opsi C --}}
                    <div class="mb-3">
                        <label class="form-label">Opsi C *</label>
                        <input type="text" name="option_c" class="form-control" value="{{ old('option_c', $question->option_c) }}" required>
                    </div>

                    {{-- Opsi D --}}
                    <div class="mb-3">
                        <label class="form-label">Opsi D *</label>
                        <input type="text" name="option_d" class="form-control" value="{{ old('option_d', $question->option_d) }}" required>
                    </div>

                    {{-- Jawaban Benar --}}
                    <div class="mb-3">
                        <label class="form-label">Jawaban Benar *</label>
                        <select name="correct_answer" class="form-control" required>
                            <option value="">-- Pilih Jawaban Benar --</option>
                            <option value="a" {{ old('correct_answer', $question->correct_answer) == 'a' ? 'selected' : '' }}>A</option>
                            <option value="b" {{ old('correct_answer', $question->correct_answer) == 'b' ? 'selected' : '' }}>B</option>
                            <option value="c" {{ old('correct_answer', $question->correct_answer) == 'c' ? 'selected' : '' }}>C</option>
                            <option value="d" {{ old('correct_answer', $question->correct_answer) == 'd' ? 'selected' : '' }}>D</option>
                        </select>
                    </div>

                    {{-- Nilai/Score --}}
                    <div class="mb-3">
                        <label class="form-label">Nilai / Score *</label>
                        <input type="number" name="score" class="form-control" value="{{ old('score', $question->score) }}" min="1" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Update Soal
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

@endsection
