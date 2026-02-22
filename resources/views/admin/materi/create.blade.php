@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Tambah Materi</h5>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-body">

                {{-- TAMPILKAN ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.materis.store') }}"
                      method="POST"
                      enctype="multipart/form-data"> {{-- WAJIB ADA INI --}}
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="form-label">Judul *</label>
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

                    {{-- Thumbnail --}}
                    <div class="mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file"
                               name="thumbnail"
                               class="form-control">
                    </div>

                    {{-- Content --}}
                    <div class="mb-3">
                        <label class="form-label">Konten *</label>
                        <div id="editor" style="height: 250px;"></div>
                        <input type="hidden" name="content" id="content">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
    <a href="{{ route('admin.materis.index') }}" class="btn btn-secondary">
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


@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>

<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    var contentInput = document.getElementById('content');

    // Set old value kalau ada
    @if(old('content'))
        quill.root.innerHTML = `{!! old('content') !!}`;
        contentInput.value = `{!! old('content') !!}`;
    @endif

    // Set hidden input setiap kali isi berubah
    quill.on('text-change', function () {
        contentInput.value = quill.root.innerHTML;
    });
</script>
@endpush
