@extends('layouts.app3')

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header {{ $result->is_passed ? 'bg-success' : 'bg-danger' }} py-4 text-center">
                        <h4 class="text-white fw-bold mb-0">HASIL QUIZ ANDA</h4>
                    </div>

                    <div class="card-body p-lg-5 text-center">
                        <h3 class="fw-bold text-dark mb-1">{{ $result->quiz->title }}</h3>
                        <p class="text-muted">Dikerjakan pada: {{ $result->created_at->format('d M Y, H:i') }}</p>

                        <hr class="my-4">

                        <div class="position-relative d-inline-block mb-4">
                            <div class="d-flex align-items-center justify-content-center rounded-circle border border-5 {{ $result->is_passed ? 'border-success' : 'border-danger' }}"
                                 style="width: 150px; height: 150px;">
                                <div>
                                    <span class="display-4 fw-bold d-block text-dark">{{ $result->score }}</span>
                                    <small class="text-muted fw-bold">SKOR</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            @if($result->is_passed)
                                <h4 class="text-success fw-bold">SELAMAT! ANDA LULUS</h4>
                                <p class="text-muted">Kerja bagus! Anda telah memahami materi ini dengan sangat baik.</p>
                            @else
                                <h4 class="text-danger fw-bold">MAAF, ANDA BELUM LULUS</h4>
                                <p class="text-muted">Jangan menyerah! Silahkan pelajari kembali materinya dan coba lagi.</p>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-3 bg-light">
                                    <h6 class="text-muted small mb-1 text-uppercase">Total Soal</h6>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $result->total_questions }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-3 bg-light">
                                    <h6 class="text-muted small mb-1 text-uppercase">Jawaban Benar</h6>
                                    <h4 class="fw-bold mb-0 text-success">{{ $result->correct_answers }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-3 bg-light">
                                    <h6 class="text-muted small mb-1 text-uppercase">Jawaban Salah</h6>
                                    <h4 class="fw-bold mb-0 text-danger">{{ $result->total_questions - $result->correct_answers }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-center mt-5">
                            <a href="{{ route('result.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                <i class="bi bi-arrow-left me-2"></i>Riwayat Hasil
                            </a>
                            <a href="{{ route('quizs.show', $result->quiz_id) }}" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-arrow-clockwise me-2"></i>Ulangi Quiz
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi sedikit agar tampilan lebih 'hidup' */
    .card {
        animation: slideUp 0.5s ease-out;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
