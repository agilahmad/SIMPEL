@extends('layouts.main')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manajemen {{ $label }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">{{ $label }}</li>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-light-brand"
                                data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="feather-bar-chart"></i>
                            </a>
                            @can('create', \App\Models\Pentest::class)
                                <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary">
                                    <i class="feather-plus me-2"></i>
                                    <span>Tambah {{ $label }}</span>
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div id="collapseOne" class="accordion-collapse collapse page-header-collapse">
                <div class="accordion-body pb-2">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Total {{ $label }}</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $items->total() }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Semua {{ $label }}</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Belum Dilakukan</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $belum_dilakukan ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Belum Dilakukan</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $items->total() > 0 ? (($belum_dilakukan ?? 0) / $items->total()) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Dalam Proses</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $proses ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Sedang Berjalan</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: {{ $items->total() > 0 ? (($proses ?? 0) / $items->total()) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Selesai</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $selesai ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Selesai</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $items->total() > 0 ? (($selesai ?? 0) / $items->total()) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="feather-x-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Aplikasi</th>
                                                <th>Tanggal {{ $label }}</th>
                                                <th>Status Perbaikan</th>
                                                <th>Tanggal Perbaikan</th>
                                                <th>Kerentanan</th>
                                                <th>Dibuat Oleh</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $pentest)
                                                <tr class="single-item">
                                                    <td>{{ $items->firstItem() + $loop->index }}</td>
                                                    <td class="project-name-td">
                                                        <div class="hstack gap-4">
                                                            <div class="avatar-image border-0">
                                                                <span class="avatar-text avatar-md bg-soft-primary text-primary rounded">
                                                                    {{ strtoupper(substr($pentest->application->application_name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route($routePrefix . '.show', $pentest) }}" class="text-truncate-1-line fw-semibold">
                                                                    {{ $pentest->application->application_name }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fs-12 text-muted">{{ $pentest->pentest_date->format('d M Y') }}</td>
                                                    <td>@include('partials.pentest-status-badge', ['status' => $pentest->repaired_status])</td>
                                                    <td class="fs-12 text-muted">
                                                        {{ $pentest->repaired_date ? $pentest->repaired_date->format('d M Y') : '—' }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-soft-primary text-primary fs-12">
                                                            {{ $pentest->vulnerability_count }} temuan
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            @if($pentest->creator)
                                                                <div class="avatar-text avatar-md bg-soft-teal text-teal rounded-circle">
                                                                    {{ strtoupper(substr($pentest->creator->name, 0, 1)) }}
                                                                </div>
                                                                <span class="fs-12 text-muted text-truncate-1-line" style="max-width:90px;">
                                                                    {{ $pentest->creator->name }}
                                                                </span>
                                                            @else
                                                                <span class="fs-12 text-muted">—</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="nxl-dropdown-action" data-nxl-dropdown>
                                                            <button type="button" class="avatar-text avatar-md nxl-dropdown-toggle" aria-label="Aksi">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </button>
                                                            <ul class="nxl-dropdown-menu dropdown-menu shadow-lg">
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route($routePrefix . '.show', $pentest) }}">
                                                                        <i class="feather feather-eye me-3"></i>
                                                                        <span>Detail</span>
                                                                    </a>
                                                                </li>
                                                                @can('update', $pentest)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route($routePrefix . '.edit', $pentest) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                @endcan
                                                                @can('delete', $pentest)
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <form method="POST" action="{{ route($routePrefix . '.destroy', $pentest) }}"
                                                                        onsubmit="return confirm('Hapus data ini?')">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                                                            <i class="feather feather-trash-2 me-3"></i>
                                                                            <span>Hapus</span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                @endcan
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-5">
                                                        <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                        Belum ada data {{ $label }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($items->hasPages())
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <p class="fs-12 text-muted mb-0">
                                        Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }} data
                                    </p>
                                    {{ $items->links() }}
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