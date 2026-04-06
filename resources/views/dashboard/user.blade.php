@extends('layouts.main')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <a href="{{ route('incidents.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i> Laporkan Insiden
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="card stretch stretch-full border-start border-primary border-3">
                        <div class="card-body">
                            <div class="hstack justify-content-between">
                                <div>
                                    <p class="fs-12 text-muted mb-1">Total Laporan Saya</p>
                                    <h4 class="fw-bolder mb-0">{{ $stats['total_incidents'] }}</h4>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded-circle">
                                    <i class="feather-file-text fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stretch stretch-full border-start border-danger border-3">
                        <div class="card-body">
                            <div class="hstack justify-content-between">
                                <div>
                                    <p class="fs-12 text-muted mb-1">Belum Dilakukan</p>
                                    <h4 class="fw-bolder text-danger mb-0">{{ $stats['incidents_belum'] }}</h4>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded-circle">
                                    <i class="feather-clock fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stretch stretch-full border-start border-warning border-3">
                        <div class="card-body">
                            <div class="hstack justify-content-between">
                                <div>
                                    <p class="fs-12 text-muted mb-1">Dalam Proses</p>
                                    <h4 class="fw-bolder text-warning mb-0">{{ $stats['incidents_proses'] }}</h4>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded-circle">
                                    <i class="feather-loader fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stretch stretch-full border-start border-success border-3">
                        <div class="card-body">
                            <div class="hstack justify-content-between">
                                <div>
                                    <p class="fs-12 text-muted mb-1">Selesai</p>
                                    <h4 class="fw-bolder text-success mb-0">{{ $stats['incidents_selesai'] }}</h4>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-success text-success rounded-circle">
                                    <i class="feather-check-circle fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Laporan Insiden Terbaru Saya</h5>
                            <div class="card-header-action">
                                <a href="{{ route('incidents.index') }}" class="btn btn-light-brand btn-sm">View All</a>
                            </div>
                        </div>
                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tiket</th>
                                            <th>Aplikasi</th>
                                            <th>Kerentanan</th>
                                            <th>Severity</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentIncidents as $incident)
                                            <tr>
                                                <td><code class="fs-12 text-primary">{{ $incident->ticket_code }}</code></td>
                                                <td class="fs-12 text-muted">{{ $incident->application->application_name }}</td>
                                                <td class="fs-12 text-muted">{{ $incident->vulnerability_name }}</td>
                                                <td>@include('partials.severity-badge', ['severity' => $incident->severity])</td>
                                                <td>@include('partials.pentest-status-badge', ['status' => $incident->repaired_status])</td>
                                                <td class="fs-12 text-muted">{{ $incident->reporting_date->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('incidents.show', $incident) }}" class="avatar-text avatar-md" title="Lihat Detail">
                                                        <i class="feather feather-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-5">
                                                    <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                    Belum ada laporan insiden
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</main>
@endsection