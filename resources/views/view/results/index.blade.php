@extends('layouts.app3')

@section('content')
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Riwayat Hasil Quiz Anda</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul Quiz</th>
                                <th>Skor</th>
                                <th>Benar/Total</th>
                                <th>Status</th>
                                <th>Tanggal Kerjakan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $res)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $res->quiz->title }}</td>
                                <td><span class="fw-bold text-primary">{{ $res->score }}</span></td>
                                <td>{{ $res->correct_answers }} / {{ $res->total_questions }}</td>
                                <td>
                                    @if($res->is_passed)
                                        <span class="badge bg-success">Lulus</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Lulus</span>
                                    @endif
                                </td>
                                <td>{{ $res->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <a href="{{ route('result.show', $res->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada hasil quiz.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
