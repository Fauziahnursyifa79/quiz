@extends('layouts.app')

@section('content')
<div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-4">
                    <div class="d-flex gap-4 align-items-center">
                        <div class="avatar-text avatar-lg bg-gray-200">
                            <i class="feather-book"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $total_quiz }}</span></div>
                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Quiz</h3>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('quiz.index') }}" class="fs-12 fw-medium text-muted">Lihat Semua Quiz</a>
                    </div>
                    <div class="progress mt-2 ht-3">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-4">
                    <div class="d-flex gap-4 align-items-center">
                        <div class="avatar-text avatar-lg bg-gray-200">
                            <i class="feather-help-circle"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $total_questions }}</span></div>
                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Pertanyaan</h3>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('questions.index') }}" class="fs-12 fw-medium text-muted">Bank Soal</a>
                    </div>
                    <div class="progress mt-2 ht-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-4">
                    <div class="d-flex gap-4 align-items-center">
                        <div class="avatar-text avatar-lg bg-gray-200">
                            <i class="feather-edit-3"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $total_user_answers }}</span></div>
                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Jawaban Masuk</h3>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('user-answers.index') }}" class="fs-12 fw-medium text-muted">Detail Jawaban</a>
                    </div>
                    <div class="progress mt-2 ht-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-4">
                    <div class="d-flex gap-4 align-items-center">
                        <div class="avatar-text avatar-lg bg-gray-200">
                            <i class="feather-award"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $total_results }}</span></div>
                            <h3 class="fs-13 fw-semibold text-truncate-1-line">Hasil Akhir</h3>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('results.index') }}" class="fs-12 fw-medium text-muted">Lihat Skor Peserta</a>
                    </div>
                    <div class="progress mt-2 ht-3">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
            <!-- [ Main Content ] end -->
</div>
@endsection
