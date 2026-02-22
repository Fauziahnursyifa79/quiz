@extends('layouts.app')

@section('content')

<div class="nxl-content">

    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Data Materi</h5>
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
                <h5>List Materi</h5>
            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    @forelse($materis as $key => $materi)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                @if($materi->thumbnail)
                                    <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                         width="60"
                                         height="60"
                                         style="object-fit: cover; border-radius:8px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $materi->title }}</td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($materi->description ?? '-', 50) }}
                            </td>

                            <td>
                                @if($materi->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                {{ optional($materi->created_at)->format('d M Y') }}
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
                                               href="{{ route('admin.materis.show', $materi->id) }}">
                                                Detail
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('materi.edit', $materi->id) }}">
                                                Edit
                                            </a>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        <li>
                                            <form action="{{ route('admin.materis.destroy', $materi->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin hapus?')">
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
                            <td colspan="7" class="text-center">
                                Belum ada data materi
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
