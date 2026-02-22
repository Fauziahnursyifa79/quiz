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
                                <h5 class="mb-1">Daftar Materi</h5>
                                <span class="fs-12 text-muted">Akses materi pembelajaran terbaru Anda</span>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-light-brand">View Alls</a>
                        </div>

                        <div class="row g-3">
                            {{-- Mulai Perulangan Data Materi --}}
                            @foreach($materis as $materi)
                                <div class="col-xxl-2 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 mb-0 position-relative">
                                        <div class="card-body rounded-3 text-center">

                                            @if($materi->thumbnail)
                                                <div class="mb-4 d-flex justify-content-center"> {{-- Bungkus div agar rata tengah --}}
                                                    <div style="width: 150px; height: 150px; background-color: #f8f9fa; padding: 10px;" class="rounded shadow-sm">
                                                        <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                                            alt="thumbnail"
                                                            style="width: 100%; height: 100%; object-fit: contain;"> {{-- 'contain' memastikan gambar utuh tidak terpotong --}}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mb-4 text-center">
                                                    <i class="bi bi-book fs-1 text-primary"></i>
                                                </div>
                                            @endif

                                            <div class="fs-4 fw-bolder text-dark mt-3 mb-1">{{ $materi->title }}</div>

                                            <p class="fs-12 fw-medium text-muted text-spacing-1 mb-4 text-truncate-1-line">
                                                {{ Str::limit($materi->description, 20) }}
                                            </p>

                                            <a href="{{ route('viewer.materi.show', $materi->id) }}" class="stretched-link"></a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- Selesai Perulangan --}}

                            @if($materis->isEmpty())
                            <div class="col-12">
                                <p class="text-center text-muted">Belum ada materi yang tersedia.</p>
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
