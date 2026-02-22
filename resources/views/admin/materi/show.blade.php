@extends('layouts.app')

@section('content')
<div class="nxl-content">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail Materi</h5>
            </div>
        </div>
        <div class="page-header-right">
            <div class="hstack gap-2">
                <a href="{{ route('admin.materis.index') }}" class="btn btn-sm btn-light-brand">
                    <i class="feather-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('admin.materis.edit', $materi->id) }}" class="btn btn-sm btn-primary">
                    <i class="feather-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Judul --}}
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-dark mb-1 h4">
                                {{ $materi->title }}
                            </h2>

                            <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                <span class="badge bg-soft-secondary text-muted small fw-normal">
                                    {{ $materi->created_at->format('d M Y') }}
                                </span>

                                <span class="badge {{ $materi->is_active ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }}">
                                    {{ $materi->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        <hr class="my-3 opacity-25">

                        {{-- Thumbnail --}}
                        @if($materi->thumbnail)
                            <div class="text-center mb-4">
                                <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                     class="rounded-3 shadow-sm img-fluid"
                                     style="max-height:200px; object-fit:contain;">
                            </div>
                        @endif


                        {{-- Deskripsi --}}
                        @if($materi->description)
                            <div class="text-center mb-2">
                                <h6 class="fw-bold mb-2">Deskripsi</h6>
                            </div>

                            <div class="materi-text text-dark text-center mb-3">
                                {!! $materi->description !!}
                            </div>
                        @endif

                        {{-- Konten --}}
                        <div class="materi-text text-dark text-center">
                            <div class="text-center mb-2">
                                <h6 class="fw-bold mb-2">Materi</h6>
                            </div>
                            {!! $materi->content !!}
                        </div>

                        {{-- Tombol --}}
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                    <i class="feather-printer me-1"></i> Cetak
                                </button>

                                <form action="{{ route('admin.materis.destroy', $materi->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="feather-trash-2 me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

/* 🔥 INI YANG BIKIN FIX */
.nxl-container,
.nxl-content,
.main-content {
    min-height: auto !important;
    height: auto !important;
}

/* supaya background tetap rapi */
body {
    background-color: #f4f7fa;
}

.materi-text {
    font-size: 1rem;
    line-height: 1.7;
}

.materi-text p {
    margin-bottom: 10px;
}

</style>
@endpush
