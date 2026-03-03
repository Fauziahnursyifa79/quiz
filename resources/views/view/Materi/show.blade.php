@extends('layouts.app3')

@section('content')
<style>
    .custom-brand-text {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #5D87A8;
        font-weight: 400;
        line-height: 1.2;
    }
    .content-area img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    /* Animasi perpindahan halaman materi */
    .page-content {
        display: none;
    }
    .page-content.active {
        display: block;
        animation: fadeIn 0.4s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="main-content p-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card stretch stretch-full border-0 shadow-sm">
                    <div class="card-body p-lg-5 text-center">

                        <div class="mb-4">
                            <h2 class="fw-bold custom-brand-text mb-1">{{ $materi->title }}</h2>
                              <p class="text-muted small mt-2">Diterbitkan pada: {{ $materi->created_at->format('d M Y') }}</p>

                            <p class="text-muted small">Materi Bagian: <span id="currentPageNum">1</span></p>
                        </div>

                       <hr class="my-4">

                        @if($materi->thumbnail)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                 alt="{{ $materi->title }}"
                                 class="rounded-4 shadow-sm"
                                 style="max-height: 250px; max-width: 100%; object-fit: contain;">
                        </div>
                        @endif
                        {{-- Bagian Konten yang akan dipisah --}}
                        <div id="pagedMateriContainer" class="content-area text-start mx-auto" style="font-size: 1.1rem; line-height: 1.8; color: #334155; max-width: 850px;">
                            {{-- Konten asli dari database ditaruh di sini dulu --}}
                            <div id="rawContent" style="display:none;">{!! $materi->content !!}</div>
                            <div id="pagesWrapper"></div>
                        </div>

                        {{-- Navigasi Halaman Materi --}}
                        <div class="mt-5 pt-4 border-top">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                {{-- Tombol Sebelumnya --}}
                                <button id="materiPrevBtn" class="btn btn-outline-primary shadow-sm px-4" onclick="changeMateriPage(-1)" style="display:none;">
                                    <i class="bi bi-chevron-left me-1"></i> Sebelumnya
                                </button>
                                <div id="spacer" style="flex-grow: 1;"></div>

                                {{-- Tombol Selanjutnya --}}
                                <button id="materiNextBtn" class="btn btn-primary shadow-sm px-4" onclick="changeMateriPage(1)" style="display:none;">
                                    Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                                </button>

                                {{-- Tombol Selesai (Hanya muncul di halaman terakhir) --}}
                                <div id="materiFinishBtn" class="w-100 text-center d-none">
                                    <div class="badge bg-soft-success text-success p-2 mb-3">
                                        <i class="bi bi-check-circle me-1"></i> Seluruh Materi Telah Dibaca
                                    </div>
                                    <div class="hstack gap-2 justify-content-center">
                                        <a href="{{ route('viewer.dashboard') }}" class="btn btn-light-brand border">
                                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                                        </a>
                                        <button class="btn btn-primary" onclick="window.print()">
                                            <i class="bi bi-printer me-1"></i> Cetak
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentMateriPage = 0;
    let totalMateriPages = 0;

    document.addEventListener("DOMContentLoaded", function() {
        const rawHtml = document.getElementById('rawContent').innerHTML;
        const pagesWrapper = document.getElementById('pagesWrapper');

        // --- LOGIKA PEMISAHAN KONTEN ---
        // Kita membagi konten berdasarkan tag <p> atau <div> agar tidak memotong kalimat di tengah
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = rawHtml;
        const elements = Array.from(tempDiv.children);

        if (elements.length === 0) {
            // Jika konten tidak punya tag (hanya teks biasa)
            pagesWrapper.innerHTML = `<div class="page-content active">${rawHtml}</div>`;
            document.getElementById('materiFinishBtn').classList.remove('d-none');
            return;
        }

        let currentPageDiv = document.createElement('div');
        currentPageDiv.className = 'page-content';
        let wordCount = 0;
        const wordsPerPage = 70; // Jarak per halaman (sekitar 150 kata)

        elements.forEach((el, index) => {
            wordCount += el.innerText.split(/\s+/).length;
            currentPageDiv.appendChild(el.cloneNode(true));

            // Jika kata sudah mencapai batas atau ini elemen terakhir
            if (wordCount >= wordsPerPage || index === elements.length - 1) {
                pagesWrapper.appendChild(currentPageDiv);
                currentPageDiv = document.createElement('div');
                currentPageDiv.className = 'page-content';
                wordCount = 0;
            }
        });

        const pages = document.querySelectorAll('.page-content');
        totalMateriPages = pages.length;
        pages[0].classList.add('active');

        updateNavigation();
    });

    function changeMateriPage(step) {
        const pages = document.querySelectorAll('.page-content');
        pages[currentMateriPage].classList.remove('active');

        currentMateriPage += step;
        pages[currentMateriPage].classList.add('active');

        document.getElementById('currentPageNum').innerText = currentMateriPage + 1;
        updateNavigation();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateNavigation() {
        const nextBtn = document.getElementById('materiNextBtn');
        const prevBtn = document.getElementById('materiPrevBtn');
        const finishBtn = document.getElementById('materiFinishBtn');

        // Tombol Sebelumnya muncul jika bukan di halaman pertama
        prevBtn.style.display = currentMateriPage > 0 ? 'inline-block' : 'none';

        // Tombol Selanjutnya muncul jika bukan di halaman terakhir
        if (currentMateriPage < totalMateriPages - 1) {
            nextBtn.style.display = 'inline-block';
            finishBtn.classList.add('d-none');
        } else {
            // Halaman Terakhir
            nextBtn.style.display = 'none';
            finishBtn.classList.remove('d-none');
        }
    }
</script>
@endsection
