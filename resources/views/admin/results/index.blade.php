@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Hasil Quiz</h5>
            </div>
        </div>
        <div class="page-header-right ms-auto">
            <a href="{{ route('results.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>Tambah Hasil
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
                <h5>List Hasil Quiz</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Quiz</th>
                                <th>Score</th>
                                <th>Total Soal</th>
                                <th>Benar</th>
                                <th>Lulus</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($results as $key => $result)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark fw-bold">{{ $result->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="text-nowrap">{{ $result->quiz->title ?? '-' }}</td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $result->score }}</span>
                                </td>
                                <td>{{ $result->total_questions }}</td>
                                <td>{{ $result->correct_answers }}</td>
                                <td>
                                    @if($result->is_passed)
                                        <span class="badge bg-soft-success text-success">Lulus</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger">Tidak Lulus</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ optional($result->created_at)->format('d M Y') }}</td>

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
                                                   href="{{ route('results.show', $result->id) }}">
                                                    Detail
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('results.edit', $result->id) }}">
                                                    Edit
                                                </a>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            <li>
                                                <form action="{{ route('results.destroy', $result->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin hapus hasil quiz ini?')">
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
                                <td colspan="9" class="text-center">
                                    Belum ada hasil quiz
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
