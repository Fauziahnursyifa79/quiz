@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Data Quiz</h5>
            </div>
        </div>
        <div class="page-header-right ms-auto">
            <a href="{{ route('quiz.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>Tambah Quiz
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h5>List Quiz</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Materi</th>
                                <th>Judul Quiz</th>
                                <th>Deskripsi</th>
                                <th>Durasi (Menit)</th>
                                <th>Nilai Lulus</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($quizzes as $key => $quiz)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td class="text-nowrap">
                                    {{ $quiz->materi->title ?? '-' }}
                                </td>

                                <td class="text-nowrap"><strong>{{ $quiz->title }}</strong></td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($quiz->description ?? '-', 50) }}
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-soft-info text-info">
                                        {{ $quiz->time_limit ?? '-' }} Min
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-soft-warning text-warning">
                                        {{ $quiz->passing_score }}
                                    </span>
                                </td>

                                <td>
                                    @if($quiz->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    {{ optional($quiz->created_at)->format('d M Y') }}
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
                                                   href="{{ route('quiz.show', $quiz->id) }}">
                                                    Detail
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('quiz.edit', $quiz->id) }}">
                                                    Edit
                                                </a>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            <li>
                                                <form action="{{ route('quiz.destroy', $quiz->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin hapus quiz ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="dropdown-item text-danger">
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
                                <td colspan="9" class="text-center">
                                    Belum ada data quiz
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
