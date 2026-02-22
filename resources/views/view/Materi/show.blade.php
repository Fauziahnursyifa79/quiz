@extends('layouts.app3')

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="row justify-content-center"> {{-- Membuat konten berada di tengah secara horizontal --}}
            <div class="col-lg-10">
                <div class="card stretch stretch-full border-0 shadow-sm">
                    <div class="card-body p-lg-5 text-center"> {{-- Teks dipaksa ke tengah semua --}}

                        <div class="mb-4">
                            <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="{{ route('viewer.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Materi</li>
                                </ol>
                            </nav>
                            <h2 class="fw-bold text-dark mb-1">{{ $materi->title }}</h2>
                            <p class="text-muted small">Diterbitkan pada: {{ $materi->created_at->format('d M Y') }}</p>
                        </div>

                        <hr class="my-4">

                        @if($materi->thumbnail)
                        <div class="mb-5">
                            <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                 alt="{{ $materi->title }}"
                                 class="rounded-4 shadow-sm"
                                 style="max-height: 250px; max-width: 100%; object-fit: contain;"> {{-- Height diperkecil jadi 250px --}}
                        </div>
                        @endif

                        <div class="card border border-gray-5 shadow-none mb-5 mx-auto" style="max-width: 800px;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3 text-primary">Deskripsi Singkat</h5>
                                <p class="mb-0 text-muted" style="line-height: 1.6;">
                                    {{ $materi->description }}
                                </p>
                            </div>
                        </div>

                        <div class="content-area mx-auto" style="font-size: 1.1rem; line-height: 1.8; color: #334155; max-width: 850px;">
                            <div class="d-inline-block text-start w-100 text-center"> {{-- Memastikan teks materi juga rata tengah --}}
                                {!! $materi->content !!}
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-top d-flex flex-column align-items-center">
                            <div class="mb-4">
                                <span class="badge bg-soft-success text-success p-2">
                                    <i class="bi bi-check-circle me-1"></i> Materi Sudah Dibuka
                                </span>
                            </div>

                            <div class="hstack gap-2 justify-content-center">
                                <a href="{{ route('viewer.dashboard') }}" class="btn btn-light-brand">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                                </a>
                                <button class="btn btn-primary shadow-sm" onclick="window.print()">
                                    <i class="bi bi-printer me-1"></i> Cetak Materi
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
