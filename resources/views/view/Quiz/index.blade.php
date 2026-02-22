@extends('layouts.app3')

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="hstack justify-content-between mb-4">
                            <div>
                                <h5 class="mb-1">Daftar Quiz</h5>
                                <span class="fs-12 text-muted">Uji pemahaman Anda melalui quiz yang tersedia</span>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-light-brand">View Alls</a>
                        </div>

                        <div class="row g-3">
                            {{-- Mulai Perulangan Data Quiz --}}
                            @foreach($quizzes as $quiz)
                                <div class="col-xxl-2 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 mb-0 position-relative">
                                        <div class="card-body rounded-3 text-center">

                                            {{-- Cek apakah Materi terkait punya thumbnail, jika tidak pakai icon --}}
                                            @if($quiz->materi && $quiz->materi->thumbnail)
                                                <div class="mb-4 d-flex justify-content-center">
                                                    <div style="width: 150px; height: 150px; background-color: #f8f9fa; padding: 10px;" class="rounded shadow-sm">
                                                        <img src="{{ asset('storage/' . $quiz->materi->thumbnail) }}"
                                                            alt="thumbnail"
                                                            style="width: 100%; height: 100%; object-fit: contain;">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mb-4 text-center">
                                                    <i class="bi bi-patch-question fs-1 text-warning"></i>
                                                </div>
                                            @endif

                                            {{-- Judul Quiz --}}
                                            <div class="fs-4 fw-bolder text-dark mt-3 mb-1">{{ $quiz->title }}</div>

                                            {{-- Info Tambahan: Nama Materi & Waktu --}}
                                            <p class="fs-12 fw-medium text-muted text-spacing-1 mb-4 text-truncate-1-line">
                                                {{ $quiz->materi->title ?? 'Umum' }} • {{ $quiz->time_limit }} Menit
                                            </p>

                                            {{-- Route mengarah ke quizs.show sesuai web.php kamu --}}
                                            <a href="{{ route('quizs.show', $quiz->id) }}" class="stretched-link"></a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- Selesai Perulangan --}}

                            @if($quizzes->isEmpty())
                            <div class="col-12">
                                <p class="text-center text-muted">Belum ada quiz yang tersedia saat ini.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
