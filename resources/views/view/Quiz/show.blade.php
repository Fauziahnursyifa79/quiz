@extends('layouts.app3')

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card stretch stretch-full border-0 shadow-sm">
                    <div class="card-body p-lg-5">

                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-dark mb-1">{{ $quiz->title }}</h2>
                            <p class="text-muted small">Materi: {{ $quiz->materi->title ?? 'Umum' }}</p>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <span class="badge bg-soft-danger text-danger px-3 py-2 fs-6">
                                    <i class="bi bi-alarm me-1"></i> <span id="timer-display">00:00</span>
                                </span>
                                <span class="badge bg-soft-info text-info px-3 py-2 fs-6">
                                    <i class="bi bi-list-ol me-1"></i> <span id="current-number">1</span> / {{ $quiz->questions->count() }} Soal
                                </span>
                            </div>
                        </div>

                        <hr class="my-4">

                        <form id="quiz-form" action="{{ route('result.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                            @foreach($quiz->questions as $index => $q)
                            <div class="question-container {{ $index == 0 ? '' : 'd-none' }}" id="q-{{ $index }}">

                                <div class="mb-5 text-center">
                                    <h4 class="fw-bold text-dark" style="line-height: 1.8;">
                                        {!! $q->question !!}
                                    </h4>
                                </div>

                                <div class="row g-3">
                                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                                    <div class="col-12">
                                        <input type="radio" class="btn-check" name="answer[{{ $q->id }}]" id="opt-{{ $q->id }}-{{ $opt }}" value="{{ $opt }}" autocomplete="off">
                                        <label class="btn btn-outline-light text-start w-100 p-3 border border-gray-5 rounded-3 shadow-sm d-flex align-items-center" for="opt-{{ $q->id }}-{{ $opt }}">
                                            <span class="badge bg-primary me-3 text-uppercase">{{ $opt }}</span>
                                            <span class="text-dark fw-medium">{{ $q->{'option_'.$opt} }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                            <div class="mt-5 pt-4 border-top d-flex justify-content-between">
                                <button type="button" class="btn btn-light-brand px-4 d-none" id="prev-btn" onclick="changeQuestion(-1)">
                                    <i class="bi bi-arrow-left me-1"></i> Sebelumnya
                                </button>

                                @if($quiz->questions->count() > 1)
                                <button type="button" class="btn btn-primary px-5 ms-auto" id="next-btn" onclick="changeQuestion(1)">
                                    Lanjut <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                                @endif

                                <button type="submit" class="btn btn-success px-5 ms-auto {{ $quiz->questions->count() > 1 ? 'd-none' : '' }}" id="submit-btn">
                                    Selesai & Kirim <i class="bi bi-check-all ms-1"></i>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Pilihan Jawaban Saat Diklik */
    .btn-check:checked + .btn-outline-light {
        background-color: #f0f7ff !important;
        border-color: #3b71ed !important;
        color: #3b71ed !important;
        box-shadow: 0 4px 12px rgba(59, 113, 237, 0.1) !important;
    }
    .btn-check:checked + .btn-outline-light .badge {
        background-color: #3b71ed !important;
    }
    .btn-outline-light:hover {
        background-color: #f8f9fa;
        border-color: #d1d5db;
    }
    .question-container {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    let currentIdx = 0;
    const totalQuestions = {{ $quiz->questions->count() }};

    // --- LOGIKA GANTI SOAL ---
    function changeQuestion(step) {
        // Sembunyikan soal saat ini
        document.getElementById(`q-${currentIdx}`).classList.add('d-none');

        // Update index
        currentIdx += step;

        // Tampilkan soal baru
        document.getElementById(`q-${currentIdx}`).classList.remove('d-none');

        // Update nomor progress
        document.getElementById('current-number').innerText = currentIdx + 1;

        // Update visibilitas tombol
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');

        // Tombol Sebelumnya
        if (currentIdx > 0) {
            prevBtn.classList.remove('d-none');
        } else {
            prevBtn.classList.add('d-none');
        }

        // Tombol Lanjut vs Selesai
        if (currentIdx === totalQuestions - 1) {
            if(nextBtn) nextBtn.classList.add('d-none');
            submitBtn.classList.remove('d-none');
        } else {
            if(nextBtn) nextBtn.classList.remove('d-none');
            submitBtn.classList.add('d-none');
        }
    }

    // --- LOGIKA TIMER COUNTDOWN ---
    let timeLimit = {{ $quiz->time_limit }}; // dalam menit
    let timeInSeconds = timeLimit * 60;
    const timerDisplay = document.getElementById('timer-display');

    const countdown = setInterval(function() {
        let minutes = Math.floor(timeInSeconds / 60);
        let seconds = timeInSeconds % 60;

        // Format 00:00
        seconds = seconds < 10 ? '0' + seconds : seconds;
        minutes = minutes < 10 ? '0' + minutes : minutes;

        timerDisplay.innerHTML = `${minutes}:${seconds}`;

        if (timeInSeconds <= 0) {
            clearInterval(countdown);
            alert("Waktu habis! Jawaban Anda akan dikirim otomatis.");
            document.getElementById('quiz-form').submit();
        } else {
            timeInSeconds--;
        }

        // Peringatan jika waktu sisa 1 menit (berubah warna merah)
        if(timeInSeconds < 60) {
            timerDisplay.parentElement.classList.replace('bg-soft-danger', 'bg-danger');
            timerDisplay.parentElement.classList.replace('text-danger', 'text-white');
        }
    }, 1000);
</script>
@endsection
