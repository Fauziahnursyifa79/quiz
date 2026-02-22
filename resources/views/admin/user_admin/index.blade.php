@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Data Jawaban User</h5>
            </div>
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
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Quiz</th>
                                <th>Soal</th>
                                <th class="text-center">Jawaban</th>
                                <th class="text-center">Status</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($answers as $key => $answer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-nowrap fw-bold">{{ $answer->result->user->name ?? 'User Tidak Ditemukan' }}</td>
                                    <td class="text-nowrap">{{ $answer->result->quiz->title ?? 'Quiz Terhapus' }}</td>
                                    <td style="min-width: 200px;">
                                        {{ \Illuminate\Support\Str::limit($answer->question->question ?? '-', 50) }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge border text-dark">{{ strtoupper($answer->selected_answer) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($answer->is_correct)
                                            <span class="badge bg-soft-success text-success">Benar</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">Salah</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $answer->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('user-answers.show', $answer->id) }}" class="btn btn-sm btn-light">
                                            <i class="feather-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <p class="text-muted m-0">Data tidak ditemukan di database.</p>
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
