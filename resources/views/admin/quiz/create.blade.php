@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Tambah Quiz</h5>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-body">

                {{-- ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('quiz.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Materi --}}
                    <div class="mb-3">
                        <label class="form-label">Materi *</label>
                        <select name="materi_id" class="form-control" required>
                            <option value="">-- Pilih Materi --</option>
                            @foreach($materis as $materi)
                                <option value="{{ $materi->id }}"
                                    {{ old('materi_id') == $materi->id ? 'selected' : '' }}>
                                    {{ $materi->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Judul Quiz --}}
                    <div class="mb-3">
                        <label class="form-label">Judul Quiz *</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control"
                               required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3">{{ old('description') }}</textarea>
                    </div>

                    {{-- Time Limit --}}
                    <div class="mb-3">
                        <label class="form-label">Time Limit (menit)</label>
                        <input type="number"
                               name="time_limit"
                               value="{{ old('time_limit') }}"
                               class="form-control"
                               min="1">
                    </div>

                    {{-- Passing Score --}}
                    <div class="mb-3">
                        <label class="form-label">Passing Score</label>
                        <input type="number"
                               name="passing_score"
                               value="{{ old('passing_score') }}"
                               class="form-control"
                               min="0">
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select name="is_active" class="form-control" required>
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('quiz.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

@endsection
