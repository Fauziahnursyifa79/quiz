@extends('layouts.app3')

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="page-header mb-4">
            <div class="page-header-title">
                <h5 class="fw-bold mb-0">Riwayat Hasil Quiz Anda</h5>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">List Hasil Quiz</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul Quiz</th>
                                <th>Skor</th>
                                <th>Benar/Total</th>
                                <th>Status</th>
                                <th>Tanggal Kerjakan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $res)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-nowrap fw-bold">{{ $res->quiz->title }}</td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $res->score }}</span>
                                </td>
                                <td class="text-nowrap">{{ $res->correct_answers }} / {{ $res->total_questions }}</td>
                                <td>
                                    @if($res->is_passed)
                                        <span class="badge bg-soft-success text-success">Lulus</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger">Tidak Lulus</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $res->created_at->format('d M Y, H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('result.show', $res->id) }}" class="btn btn-sm btn-light">
                                        <i class="feather-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Belum ada riwayat hasil quiz.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> </div>
        </div>
    </div>
</div>
@endsection
