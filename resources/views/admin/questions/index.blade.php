@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Data Soal</h5>
            </div>
        </div>
        <div class="page-header-right ms-auto">
            <a href="{{ route('questions.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>Tambah Soal
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h5>List Soal</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Quiz</th>
                                <th>Pertanyaan</th>
                                <th>Opsi A</th>
                                <th>Opsi B</th>
                                <th>Opsi C</th>
                                <th>Opsi D</th>
                                <th>Jawaban Benar</th>
                                <th>Nilai</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($questions as $key => $question)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="text-nowrap">{{ $question->quiz->title ?? '-' }}</td>
                                <td style="min-width: 200px;">
                                    {{ \Illuminate\Support\Str::limit($question->question, 50) }}
                                </td>
                                <td>{{ $question->option_a }}</td>
                                <td>{{ $question->option_b }}</td>
                                <td>{{ $question->option_c }}</td>
                                <td>{{ $question->option_d }}</td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary">
                                        {{ strtoupper($question->correct_answer) }}
                                    </span>
                                </td>
                                <td>{{ $question->score ?? '-' }}</td>
                                <td class="text-nowrap">
                                    {{ optional($question->created_at)->format('d M Y') }}
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="avatar-text avatar-md"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="feather feather-more-horizontal"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('questions.show', $question->id) }}">
                                                    Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('questions.edit', $question->id) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('questions.destroy', $question->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin hapus soal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    Belum ada data soal
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
