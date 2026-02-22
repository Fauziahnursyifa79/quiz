@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header d-flex align-items-center justify-content-between">
        <div class="page-header-title">
            <h5 class="m-b-10">Data Jawaban User</h5>
        </div>

        <div class="page-header-right">
            <a href="{{ route('user-answers.create') }}" class="btn btn-primary">
                + Tambah Jawaban
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h5>List Jawaban Peserta</h5>
            </div>

            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Quiz</th>
                            <th>Soal</th>
                            <th>Jawaban Terpilih</th>
                            <th>Benar/Salah</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($answers as $key => $answer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $answer->result->user->name ?? 'User Tidak Ditemukan' }}</td>
                                <td>{{ $answer->result->quiz->title ?? 'Quiz Terhapus' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($answer->question->question ?? '-', 50) }}</td>
                                <td><span class="badge border text-dark">{{ strtoupper($answer->selected_answer) }}</span></td>
                                <td>
                                    @if($answer->is_correct)
                                        <span class="badge bg-success">Benar</span>
                                    @else
                                        <span class="badge bg-danger">Salah</span>
                                    @endif
                                </td>
                                <td>{{ $answer->created_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                </td>
                                <td>
    <a href="{{ route('user-answers.show', $answer->id) }}" class="btn btn-sm btn-info text-white">
        <i class="bi bi-eye me-1"></i> Detail
    </a>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-muted">Data tidak ditemukan di database.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
