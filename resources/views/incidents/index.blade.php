@extends('layouts.main')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            @if ($type === 'potential_incident')
                                Potensi Insiden
                            @elseif($type === 'community_report')
                                Laporan Masyarakat
                            @elseif(auth()->user()->isProgrammer())
                                Assigned to Me
                            @else
                                Semua Insiden
                            @endif
                        </h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Insiden</li>
                    </ul>
                </div>
                @if (!auth()->user()->isProgrammer())
                    <div class="page-header-right ms-auto">
                        <div class="page-header-right-items">
                            <div class="d-flex d-md-none">
                                <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                    <i class="feather-arrow-left me-2"></i>
                                    <span>Back</span>
                                </a>
                            </div>
                            @if (auth()->user()->isProgrammer() || auth()->user()->isAdmin())
                                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                                    <a href="javascript:void(0);" class="btn btn-icon btn-light-brand"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        <i class="feather-bar-chart"></i>
                                    </a>
                                    <div class="dropdown">
                                        <a class="btn btn-icon btn-light-brand" data-bs-toggle="dropdown"
                                            data-bs-offset="0,10" data-bs-auto-close="outside">
                                            <i class="feather-filter"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('incidents.index', ['type' => $type]) }}"
                                                class="dropdown-item">
                                                <span
                                                    class="wd-7 ht-7 bg-primary rounded-circle d-inline-block me-3"></span>
                                                <span>Semua</span>
                                            </a>
                                            <a href="{{ route('incidents.index', ['type' => $type, 'severity' => 'critical']) }}"
                                                class="dropdown-item">
                                                <span class="wd-7 ht-7 bg-danger rounded-circle d-inline-block me-3"></span>
                                                <span>Critical</span>
                                            </a>
                                            <a href="{{ route('incidents.index', ['type' => $type, 'severity' => 'high']) }}"
                                                class="dropdown-item">
                                                <span
                                                    class="wd-7 ht-7 bg-warning rounded-circle d-inline-block me-3"></span>
                                                <span>High</span>
                                            </a>
                                            <a href="{{ route('incidents.index', ['type' => $type, 'severity' => 'medium']) }}"
                                                class="dropdown-item">
                                                <span class="wd-7 ht-7 bg-indigo rounded-circle d-inline-block me-3"></span>
                                                <span>Medium</span>
                                            </a>
                                            <a href="{{ route('incidents.index', ['type' => $type, 'severity' => 'low']) }}"
                                                class="dropdown-item">
                                                <span
                                                    class="wd-7 ht-7 bg-success rounded-circle d-inline-block me-3"></span>
                                                <span>Low</span>
                                            </a>
                                            <a href="{{ route('incidents.index', ['type' => $type, 'severity' => 'informational']) }}"
                                                class="dropdown-item">
                                                <span
                                                    class="wd-7 ht-7 bg-secondary rounded-circle d-inline-block me-3"></span>
                                                <span>Informational</span>
                                            </a>
                                        </div>
                                    </div>
                                    <a href="{{ route('incidents.create', ['type' => $type]) }}" class="btn btn-primary">
                                        <i class="feather-plus me-2"></i>
                                        <span>Tambah Insiden</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="d-md-none d-flex align-items-center">
                            <a href="javascript:void(0)" class="page-header-right-open-toggle">
                                <i class="feather-align-right fs-20"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div id="collapseOne" class="accordion-collapse collapse page-header-collapse">
                <div class="accordion-body pb-2">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Critical</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['critical'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Insiden Kritis</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $stats['critical_pct'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">High</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['high'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Insiden Tinggi</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: {{ $stats['high_pct'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Medium</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['medium'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Insiden Menengah</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ $stats['medium_pct'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Low</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['low'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Insiden Rendah</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $stats['low_pct'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Informational</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['informational'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Informasi</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                style="width: {{ $stats['informational_pct'] ?? 0 }}%"></div>
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
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['belum'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Belum Diproses</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-dark" role="progressbar"
                                                style="width: {{ $stats['belum_pct'] ?? 0 }}%"></div>
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
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['in_progress'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Sedang Diperbaiki</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $stats['in_progress_pct'] ?? 0 }}%"></div>
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
                                        <span class="fs-24 fw-bolder d-block">{{ $stats['resolved'] ?? 0 }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Telah Diperbaiki</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $stats['resolved_pct'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body">
                                    <a href="javascript:void(0);" class="fw-bold d-block">
                                        <span class="d-block">Total</span>
                                        <span class="fs-24 fw-bolder d-block">{{ $incidents->total() }}</span>
                                    </a>
                                    <div class="pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                                <span>Semua Insiden</span>
                                                <i class="feather-link-2 fs-10 ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="feather-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (!request()->routeIs('potential-incidents.*'))
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <a href="{{ route('incidents.index', request()->only(['type', 'severity'])) }}"
                            class="btn {{ !request()->routeIs('incidents.masyarakat') ? 'btn-primary' : 'btn-light-brand' }}">
                            <i class="feather-database me-2"></i>Data Internal
                        </a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('incidents.masyarakat') }}"
                                class="btn {{ request()->routeIs('incidents.masyarakat') ? 'btn-primary' : 'btn-light-brand' }} position-relative">
                                <i class="feather-globe me-2"></i>Portal Publik
                                @if ($unreadCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size:9px;">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        @endif
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="incidentList">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Tiket / Kerentanan</th>
                                                <th>Aplikasi</th>
                                                <th>Jenis</th>
                                                <th>Severity</th>
                                                <th>Status Perbaikan</th>
                                                <th>Programmer</th>
                                                <th>Tanggal</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($incidents as $incident)
                                                <tr class="single-item">
                                                    <td>{{ $incidents->firstItem() + $loop->index }}</td>
                                                    <td class="project-name-td">
                                                        <div class="hstack gap-4">
                                                            <div class="avatar-image border-0">
                                                                <span
                                                                    class="avatar-text avatar-md
                                                                    @if ($incident->severity === 'critical') bg-soft-danger text-danger
                                                                    @elseif($incident->severity === 'high') bg-soft-warning text-warning
                                                                    @elseif($incident->severity === 'medium') bg-soft-indigo text-indigo
                                                                    @else bg-soft-success text-success @endif rounded">
                                                                    <i class="feather-alert-circle"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('incidents.show', $incident) }}"
                                                                    class="text-truncate-1-line fw-semibold">
                                                                    {{ $incident->vulnerability_name }}
                                                                </a>
                                                                <p class="fs-12 text-muted mt-1 mb-0">
                                                                    <code
                                                                        class="fs-11">{{ $incident->ticket_code }}</code>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <div
                                                                class="avatar-text avatar-md bg-soft-primary text-primary rounded">
                                                                {{ strtoupper(substr($incident->application->application_name ?? ($incident->application_name ?? '?'), 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="text-truncate-1-line fs-13"
                                                                    style="max-width:120px;display:block;">
                                                                    {{ $incident->application->application_name ?? ($incident->application_name ?? '—') }}
                                                                </span>
                                                                @if (!$incident->application_id && $incident->application_name)
                                                                    <span class="badge bg-soft-warning text-warning"
                                                                        style="font-size:9px;">Belum
                                                                        diverifikasi</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($incident->type->value === 'potential_incident')
                                                            <span class="badge bg-soft-warning text-warning">Potensi
                                                                Insiden</span>
                                                        @else
                                                            <span class="badge bg-soft-info text-info">Laporan
                                                                Masyarakat</span>
                                                        @endif
                                                    </td>
                                                    <td>@include('partials.severity-badge', [
                                                        'severity' => $incident->severity,
                                                    ])</td>
                                                    <td>@include('partials.pentest-status-badge', [
                                                        'status' => $incident->repaired_status,
                                                    ])</td>
                                                    <td>
                                                        <div class="hstack gap-2">
                                                            @if ($incident->pic)
                                                                <div
                                                                    class="avatar-text avatar-sm bg-soft-success text-success rounded-circle">
                                                                    {{ strtoupper(substr($incident->pic->name, 0, 1)) }}
                                                                </div>
                                                                <span class="fs-12 text-muted text-truncate-1-line"
                                                                    style="max-width:90px;">
                                                                    {{ $incident->pic->name }}
                                                                </span>
                                                            @else
                                                                <span class="fs-12 text-muted">—</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="fs-12 text-muted">
                                                        {{ $incident->reporting_date->format('d M Y') }}</td>
                                                    <td class="text-end">
                                                        @if (auth()->user()->isAdmin())
                                                            <div class="nxl-dropdown-action" data-nxl-dropdown>
                                                                <button type="button"
                                                                    class="avatar-text avatar-md nxl-dropdown-toggle"
                                                                    aria-label="Aksi">
                                                                    <i class="feather feather-more-horizontal"></i>
                                                                </button>
                                                                <ul class="nxl-dropdown-menu dropdown-menu shadow-lg">
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('incidents.show', $incident) }}">
                                                                            <i class="feather feather-eye me-3"></i>
                                                                            <span>Lihat Detail</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="dropdown-divider"></li>
                                                                    <li>
                                                                        <form method="POST"
                                                                            action="{{ route('incidents.destroy', $incident) }}"
                                                                            onsubmit="return confirm('Hapus insiden {{ $incident->ticket_code }}?')">
                                                                            @csrf @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                                                                <i
                                                                                    class="feather feather-trash-2 me-3"></i>
                                                                                <span>Hapus</span>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <a href="{{ route('incidents.show', $incident) }}"
                                                                class="avatar-text avatar-md" title="Lihat Detail">
                                                                <i class="feather feather-eye"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center text-muted py-5">
                                                        <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                        Belum ada data insiden
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($incidents->hasPages())
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <p class="fs-12 text-muted mb-0">
                                        Menampilkan {{ $incidents->firstItem() }}–{{ $incidents->lastItem() }} dari
                                        {{ $incidents->total() }} data
                                    </p>
                                    {{ $incidents->links() }}
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
