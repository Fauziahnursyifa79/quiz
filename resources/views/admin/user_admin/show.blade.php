@extends('layouts.app') {{-- Sesuaikan dengan layout admin kamu --}}

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card stretch stretch-full border-0 shadow-sm">
                    <div class="card-body p-lg-5">

                        {{-- Header Section --}}
                        <div class="mb-4 text-center">
                            <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('user-answers.index') }}">Daftar Peserta</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Jawaban</li>
                                </ol>
                            </nav>
                            <h2 class="fw-bold text-dark mb-1">Detail Jawaban Peserta</h2>
                            <p class="text-muted small">ID Transaksi: #UA-{{ $answer->id }} | Waktu: {{ $answer->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <hr class="my-4">

                        {{-- User Information Card --}}
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="card border border-gray-5 shadow-none h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-person me-2"></i>Informasi Peserta</h6>
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td class="text-muted" style="width: 120px;">Nama</td>
                                                <td class="fw-bold">: {{ $answer->result->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Email</td>
                                                <td>: {{ $answer->result->user->email }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border border-gray-5 shadow-none h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-journal-text me-2"></i>Informasi Quiz</h6>
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td class="text-muted" style="width: 120px;">Judul Quiz</td>
                                                <td class="fw-bold text-dark">: {{ $answer->result->quiz->title }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Status Kelulusan</td>
                                                <td>:
                                                    @if($answer->result->is_passed)
                                                        <span class="badge bg-soft-success text-success">LULUS</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">TIDAK LULUS</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Question & Answer Section --}}
                        <div class="card border border-gray-5 shadow-none mb-5 mx-auto" style="max-width: 850px;">
                            <div class="card-header bg-light py-3">
                                <h5 class="fw-bold mb-0 text-dark">Pertanyaan</h5>
                            </div>
                            <div class="card-body py-4">
                                <div class="mb-4">
                                    <p class="fs-5 text-dark" style="line-height: 1.6;">
                                        {!! $answer->question->question_text !!}
                                    </p>
                                </div>

                                <div class="row g-3">
                                    @php
                                        $options = ['a', 'b', 'c', 'd'];
                                    @endphp

                                    @foreach($options as $option)
                                        @php
                                            $optionText = "option_" . $option;
                                            $isUserChoice = ($answer->selected_answer == $option);
                                            $isCorrectChoice = ($answer->question->correct_answer == $option);

                                            $borderClass = 'border-gray-5';
                                            $bgClass = '';
                                            $icon = '';

                                            if ($isUserChoice && $isCorrectChoice) {
                                                $borderClass = 'border-success';
                                                $bgClass = 'bg-soft-success';
                                                $icon = '<i class="bi bi-check-circle-fill text-success ms-auto"></i>';
                                            } elseif ($isUserChoice && !$isCorrectChoice) {
                                                $borderClass = 'border-danger';
                                                $bgClass = 'bg-soft-danger';
                                                $icon = '<i class="bi bi-x-circle-fill text-danger ms-auto"></i>';
                                            } elseif ($isCorrectChoice) {
                                                $borderClass = 'border-success';
                                                $bgClass = 'bg-light';
                                                $icon = '<small class="text-success ms-auto fw-bold">Jawaban Benar</small>';
                                            }
                                        @endphp

                                        <div class="col-12">
                                            <div class="d-flex align-items-center p-3 border rounded-3 {{ $borderClass }} {{ $bgClass }}">
                                                <span class="badge {{ $isUserChoice ? 'bg-primary' : 'bg-secondary' }} me-3">
                                                    {{ strtoupper($option) }}
                                                </span>
                                                <span class="{{ $isUserChoice ? 'fw-bold' : '' }}">
                                                    {{ $answer->question->$optionText }}
                                                </span>
                                                {!! $icon !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Summary Section --}}
                        <div class="content-area mx-auto text-center" style="max-width: 850px;">
                            <div class="p-4 rounded-4 bg-light border border-dashed">
                                <h6 class="text-muted mb-2">Kesimpulan Jawaban</h6>
                                @if($answer->is_correct)
                                    <h4 class="text-success fw-bold"><i class="bi bi-check-lg"></i> BENAR</h4>
                                    <p class="mb-0">Peserta memilih jawaban yang tepat sesuai kunci jawaban.</p>
                                @else
                                    <h4 class="text-danger fw-bold"><i class="bi bi-x-lg"></i> SALAH</h4>
                                    <p class="mb-0">Peserta memilih pilihan <strong>{{ strtoupper($answer->selected_answer) }}</strong>, sedangkan kunci jawaban adalah <strong>{{ strtoupper($answer->question->correct_answer) }}</strong>.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="mt-5 pt-4 border-top d-flex flex-column align-items-center">
                            <div class="hstack gap-2 justify-content-center">
                                <a href="{{ route('user-answers.index') }}" class="btn btn-light border shadow-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                                </a>
                                <button class="btn btn-primary shadow-sm" onclick="window.print()">
                                    <i class="bi bi-printer me-1"></i> Cetak Detail
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
