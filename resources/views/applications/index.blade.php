@extends('layouts.main')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Manajemen Aplikasi</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Aplikasi</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('applications.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Tambah Aplikasi</span>
                        </a>
                    </div>
                </div>
                <div class="d-md-none d-flex align-items-center">
                    <a href="javascript:void(0)" class="page-header-right-open-toggle">
                        <i class="feather-align-right fs-20"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="feather-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="applicationList">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Aplikasi</th>
                                            <th>Programmer</th>
                                            <th>Jumlah Pentest</th>
                                            <th>Jumlah Insiden</th>
                                            <th>Jumlah VA</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($applications as $app)
                                        <tr class="single-item">
                                            <td>{{ $applications->firstItem() + $loop->index }}</td>
                                            <td class="project-name-td">
                                                <div class="hstack gap-4">
                                                    <div class="avatar-image border-0">
                                                        <span class="avatar-text avatar-md bg-soft-primary text-primary rounded">
                                                            {{ strtoupper(substr($app->application_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('applications.edit', $app) }}" class="text-truncate-1-line fw-semibold">
                                                            {{ $app->application_name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="hstack gap-3">
                                                    @if($app->programmer)
                                                    <div class="avatar-text avatar-md bg-soft-success text-success rounded-circle">
                                                        {{ strtoupper(substr($app->programmer->name, 0, 1)) }}
                                                    </div>
                                                    <span class="text-truncate-1-line">{{ $app->programmer->name }}</span>
                                                    @else
                                                    <span class="fs-12 text-muted">Belum ditugaskan</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-primary text-primary fs-12">
                                                    {{ $app->pentests_count ?? $app->pentests()->count() }} Pentest
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-danger text-danger fs-12">
                                                    {{ $app->incidents()->where('type', 'community_report')->count() }} Lap. Mas
                                                </span>
                                                <span class="badge bg-soft-warning text-warning fs-12">
                                                    {{ $app->incidents()->where('type', 'potential_incident')->count() }} Potensi
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-info text-info fs-12">
                                                    {{ $app->vas_count ?? $app->vas()->count() }} VA
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="nxl-dropdown-action" data-nxl-dropdown>
                                                    <button type="button" class="avatar-text avatar-md nxl-dropdown-toggle" aria-label="Aksi">
                                                        <i class="feather feather-more-horizontal"></i>
                                                    </button>
                                                    <ul class="nxl-dropdown-menu dropdown-menu shadow-lg">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('applications.edit', $app) }}">
                                                                <i class="feather feather-edit-3 me-3"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" action="{{ route('applications.destroy', $app) }}"
                                                                onsubmit="return confirm('Hapus aplikasi ini?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                                                    <i class="feather feather-trash-2 me-3"></i>
                                                                    <span>Hapus</span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-5">
                                                <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                Belum ada data aplikasi
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($applications->hasPages())
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <p class="fs-12 text-muted mb-0">
                                Menampilkan {{ $applications->firstItem() }}–{{ $applications->lastItem() }} dari {{ $applications->total() }} data
                            </p>
                            {{ $applications->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</main>
@endsection

@push('js')
@include('partials.nxl-dropdown-js')
@endpush