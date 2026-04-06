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
            </div>

            <div class="main-content">
                <div class="row">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full border-start border-primary border-3">
                            <div class="card-body">
                                <div class="hstack justify-content-between">
                                    <div>
                                        <p class="fs-12 text-muted mb-1">Total Ditugaskan</p>
                                        <h4 class="fw-bolder mb-0">{{ $totalAssigned }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded-circle">
                                        <i class="feather-briefcase fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full border-start border-danger border-3">
                            <div class="card-body">
                                <div class="hstack justify-content-between">
                                    <div>
                                        <p class="fs-12 text-muted mb-1">Belum Dilakukan</p>
                                        <h4 class="fw-bolder text-danger mb-0">{{ $openCount }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded-circle">
                                        <i class="feather-alert-circle fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full border-start border-warning border-3">
                            <div class="card-body">
                                <div class="hstack justify-content-between">
                                    <div>
                                        <p class="fs-12 text-muted mb-1">Dalam Proses</p>
                                        <h4 class="fw-bolder text-warning mb-0">{{ $onProgressCount }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded-circle">
                                        <i class="feather-loader fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full border-start border-success border-3">
                            <div class="card-body">
                                <div class="hstack justify-content-between">
                                    <div>
                                        <p class="fs-12 text-muted mb-1">Selesai</p>
                                        <h4 class="fw-bolder text-success mb-0">{{ $resolvedCount }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-success text-success rounded-circle">
                                        <i class="feather-check-circle fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Distribusi Severity</h5>
                            </div>
                            <div class="card-body custom-card-action">
                                <div id="programmer-severity-chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Insiden Terbaru Ditugaskan</h5>
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
                                                <th>Kerentanan</th>
                                                <th>Severity</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($assignedIncidents as $incident)
                                                <tr>
                                                    <td><code class="fs-12 text-primary">{{ $incident->ticket_code }}</code></td>
                                                    <td class="fs-12 text-muted">{{ $incident->vulnerability_name }}</td>
                                                    <td>@include('partials.severity-badge', ['severity' => $incident->severity])</td>
                                                    <td>@include('partials.pentest-status-badge', ['status' => $incident->repaired_status])</td>
                                                    <td>
                                                        <a href="{{ route('incidents.show', $incident) }}" class="avatar-text avatar-md" title="Lihat Detail">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-5">
                                                        <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                        Belum ada insiden ditugaskan
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

@push('js')
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script>
        const severityData = @json($severityChart);
        const severityColors = {
            informational: '#6c757d',
            low:           '#0dcaf0',
            medium:        '#ffc107',
            high:          '#fd7e14',
            critical:      '#dc3545',
        };
        const keys   = Object.keys(severityData);
        const values = Object.values(severityData).map(Number);
        const total  = values.reduce((a, b) => a + b, 0);

        if (total === 0) {
            document.querySelector('#programmer-severity-chart').innerHTML =
                '<p class="text-center text-muted py-4 mb-0 fs-12">Belum ada data severity</p>';
        } else {
            new ApexCharts(document.querySelector('#programmer-severity-chart'), {
                chart: {
                    type: 'donut',
                    height: 280,
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    animations: { enabled: true, easing: 'easeinout', speed: 500 },
                },
                series: values,
                labels: keys.map(k => k.charAt(0).toUpperCase() + k.slice(1)),
                colors: keys.map(k => severityColors[k] || '#6c757d'),
                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%',
                            labels: {
                                show: true,
                                total: { show: true, label: 'Total', fontSize: '12px', fontWeight: 600, color: '#495057' },
                            },
                        },
                    },
                },
                dataLabels: { enabled: false },
                stroke: { width: 2, colors: ['#fff'] },
                legend: { position: 'bottom', fontSize: '12px', markers: { radius: 3 }, itemMargin: { horizontal: 6 } },
                tooltip: { style: { fontSize: '12px' } },
            }).render();
        }
    </script>
@endpush