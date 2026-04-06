@extends('layouts.main')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard Admin</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
            </div>

            <div class="main-content">

                <div class="row mb-4">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full border-start border-primary border-3">
                            <div class="card-body">
                                <div class="hstack justify-content-between">
                                    <div>
                                        <p class="fs-12 text-muted mb-1">Total Pentest</p>
                                        <h4 class="fw-bolder mb-0">{{ $stats['total_pentests'] }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded-circle">
                                        <i class="feather-shield fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full border-start border-purple border-3">
                            <div class="card-body">
                                <div class="hstack justify-content-between">
                                    <div>
                                        <p class="fs-12 text-muted mb-1">Total VA</p>
                                        <h4 class="fw-bolder mb-0">{{ $stats['total_vas'] }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-purple text-purple rounded-circle">
                                        <i class="feather-search fs-4"></i>
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
                                        <p class="fs-12 text-muted mb-1">Total Insiden</p>
                                        <h4 class="fw-bolder mb-0">{{ $stats['total_incident'] }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded-circle">
                                        <i class="feather-alert-triangle fs-4"></i>
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
                                        <p class="fs-12 text-muted mb-1">Critical Belum Diperbaiki</p>
                                        <h4 class="fw-bolder text-danger mb-0">{{ $stats['critical_unfixed'] }}</h4>
                                    </div>
                                    <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded-circle">
                                        <i class="feather-alert-octagon fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pentest" role="tab">
                            <i class="feather-shield me-1"></i> Pentest
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#va" role="tab">
                            <i class="feather-search me-1"></i> Vulnerability Assessment
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#potensi" role="tab">
                            <i class="feather-alert-triangle me-1"></i> Potensi Insiden
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#laporan" role="tab">
                            <i class="feather-users me-1"></i> Laporan Masyarakat
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    {{-- TAB PENTEST --}}
                    <div class="tab-pane fade show active" id="pentest" role="tabpanel">
                        @include('dashboard.partials.pentest-tab', ['data' => $pentestStats, 'prefix' => 'pentest', 'color' => 'primary', 'routeType' => 'pentest'])
                    </div>

                    {{-- TAB VA --}}
                    <div class="tab-pane fade" id="va" role="tabpanel">
                        @include('dashboard.partials.pentest-tab', ['data' => $vaStats, 'prefix' => 'va', 'color' => 'purple', 'routeType' => 'vulnerability_assessment'])
                    </div>

                    {{-- TAB POTENSI INSIDEN --}}
                    <div class="tab-pane fade" id="potensi" role="tabpanel">
                        @include('dashboard.partials.incident-tab', ['data' => $potensiStats, 'prefix' => 'potensi', 'incidentType' => 'potential_incident', 'label' => 'Potensi Insiden'])
                    </div>

                    {{-- TAB LAPORAN MASYARAKAT --}}
                    <div class="tab-pane fade" id="laporan" role="tabpanel">
                        @include('dashboard.partials.incident-tab', ['data' => $laporanStats, 'prefix' => 'laporan', 'incidentType' => 'community_report', 'label' => 'Laporan Masyarakat', 'showReporter' => true])
                    </div>

                </div>
            </div>
        </div>
        @include('layouts.footer')
    </main>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script>
        const allChartData = {
            pentest: {
                repaired:    @json($pentestStats['repaired_status']),
                severity:    @json($pentestStats['severity']),
                perYear:     @json($pentestStats['per_year']),
                findings:    @json($pentestStats['finding_types']),
                programmer:  @json($pentestStats['programmer_stats']->pluck('pentest_count', 'name')),
                app:         @json($pentestStats['app_count']->pluck('pentests_count', 'application_name')),
            },
            va: {
                repaired:    @json($vaStats['repaired_status']),
                severity:    @json($vaStats['severity']),
                perYear:     @json($vaStats['per_year']),
                findings:    @json($vaStats['finding_types']),
                programmer:  @json($vaStats['programmer_stats']->pluck('pentest_count', 'name')),
                app:         @json($vaStats['app_count']->pluck('pentests_count', 'application_name')),
            },
            potensi: {
                repaired:    @json($potensiStats['repaired_status']),
                severity:    @json($potensiStats['severity']),
                perYear:     @json($potensiStats['per_year']),
                findings:    @json($potensiStats['finding_types']),
                programmer:  @json($potensiStats['programmer_stats']->pluck('incident_count', 'name')),
                app:         @json($potensiStats['app_count']->pluck('incident_count', 'application_name')),
            },
            laporan: {
                repaired:    @json($laporanStats['repaired_status']),
                severity:    @json($laporanStats['severity']),
                perYear:     @json($laporanStats['per_year']),
                findings:    @json($laporanStats['finding_types']),
                programmer:  @json($laporanStats['programmer_stats']->pluck('incident_count', 'name')),
                app:         @json($laporanStats['app_count']->pluck('incident_count', 'application_name')),
            },
        };

        const STATUS_LABELS = {
            belum_dilakukan: 'Belum Dilakukan',
            dalam_proses:    'Dalam Proses',
            selesai:         'Selesai',
        };

        const SEVERITY_COLORS = {
            informational: '#6c757d',
            low:           '#0dcaf0',
            medium:        '#ffc107',
            high:          '#fd7e14',
            critical:      '#dc3545',
        };

        const TAB_ACCENT = {
            pentest: '#0d6efd',
            va:      '#6f42c1',
            potensi: '#fd7e14',
            laporan: '#0dcaf0',
        };

        const BASE_CHART = {
            fontFamily: 'inherit',
            toolbar:    { show: false },
            animations: { enabled: true, easing: 'easeinout', speed: 500 },
        };

        function intTick(values) {
            const max = Math.max(...values.map(Number).filter(isFinite), 0);
            if (max === 0) return { min: 0, max: 4, tickAmount: 4 };
            if (max <= 5)  return { min: 0, max: max, tickAmount: max };
            return { min: 0 };
        }

        const intFmt = v => Number.isFinite(v) ? String(Math.floor(v)) : v;

        function renderDonut(id, data) {
            const keys   = Object.keys(data);
            const values = Object.values(data).map(Number);
            const el     = document.querySelector('#' + id);
            if (!el) return;
            if (!values.reduce((a, b) => a + b, 0)) {
                el.innerHTML = '<p class="text-center text-muted py-4 mb-0 fs-12">Belum ada data</p>';
                return;
            }
            new ApexCharts(el, {
                chart:  { ...BASE_CHART, type: 'donut', height: 260 },
                series: values,
                labels: keys.map(k => STATUS_LABELS[k] || k),
                colors: ['#dc3545', '#ffc107', '#198754'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%',
                            labels: {
                                show:  true,
                                total: { show: true, label: 'Total', fontSize: '12px', fontWeight: 600, color: '#495057' },
                            },
                        },
                    },
                },
                dataLabels: { enabled: false },
                stroke:     { width: 2, colors: ['#fff'] },
                legend:     { position: 'bottom', fontSize: '12px', markers: { radius: 3 }, itemMargin: { horizontal: 6 } },
                tooltip:    { style: { fontSize: '12px' } },
            }).render();
        }

        function renderSeverityBar(id, data) {
            const keys   = Object.keys(data);
            const values = Object.values(data).map(Number);
            const tick   = intTick(values);
            const el     = document.querySelector('#' + id);
            if (!el) return;
            new ApexCharts(el, {
                chart:   { ...BASE_CHART, type: 'bar', height: 260 },
                series:  [{ name: 'Jumlah', data: values }],
                xaxis:   { categories: keys.map(k => k.charAt(0).toUpperCase() + k.slice(1)), labels: { style: { fontSize: '12px' } } },
                yaxis:   { ...tick, labels: { style: { fontSize: '12px' }, formatter: intFmt } },
                colors:  keys.map(k => SEVERITY_COLORS[k] || '#6c757d'),
                plotOptions: { bar: { distributed: true, borderRadius: 5, columnWidth: '48%' } },
                dataLabels: { enabled: true, style: { fontSize: '11px', colors: ['#fff'] }, formatter: intFmt },
                legend:  { show: false },
                grid:    { borderColor: '#dee2e6', strokeDashArray: 4 },
                tooltip: { style: { fontSize: '12px' }, y: { formatter: intFmt } },
            }).render();
        }

        function renderArea(id, data, accent) {
            const values = Object.values(data).map(Number);
            const tick   = intTick(values);
            const el     = document.querySelector('#' + id);
            if (!el) return;
            new ApexCharts(el, {
                chart:   { ...BASE_CHART, type: 'area', height: 260 },
                series:  [{ name: 'Jumlah', data: values }],
                xaxis:   { categories: Object.keys(data).map(String), labels: { style: { fontSize: '12px' } } },
                yaxis:   { ...tick, labels: { style: { fontSize: '12px' }, formatter: intFmt } },
                colors:  [accent],
                fill:    { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.25, opacityTo: 0.02, stops: [0, 100] } },
                dataLabels: { enabled: false },
                stroke:  { curve: 'smooth', width: 2.5 },
                markers: { size: 4, strokeWidth: 0, fillOpacity: 1 },
                grid:    { borderColor: '#dee2e6', strokeDashArray: 4 },
                tooltip: { style: { fontSize: '12px' }, y: { formatter: intFmt } },
            }).render();
        }

        function renderHBar(id, data, accent) {
            const entries = Object.entries(data).slice(0, 8);
            const el      = document.querySelector('#' + id);
            if (!el) return;
            if (!entries.length) {
                el.innerHTML = '<p class="text-center text-muted py-4 mb-0 fs-12">Belum ada data</p>';
                return;
            }
            const values = entries.map(e => Number(e[1]));
            const tick   = intTick(values);
            new ApexCharts(el, {
                chart:   { ...BASE_CHART, type: 'bar', height: Math.max(200, entries.length * 32) },
                series:  [{ name: 'Jumlah', data: values }],
                xaxis:   { categories: entries.map(e => e[0]), labels: { style: { fontSize: '11px' } } },
                yaxis:   { ...tick, labels: { style: { fontSize: '11px' }, formatter: intFmt } },
                plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '52%' } },
                colors:  [accent],
                dataLabels: {
                    enabled:  true,
                    offsetX:  4,
                    style:    { fontSize: '11px', colors: ['#212529'] },
                    formatter: intFmt,
                },
                grid:    { borderColor: '#dee2e6', strokeDashArray: 4 },
                tooltip: { style: { fontSize: '12px' }, y: { formatter: intFmt } },
            }).render();
        }

        document.addEventListener('DOMContentLoaded', function () {
            Object.entries(allChartData).forEach(([prefix, d]) => {
                const accent = TAB_ACCENT[prefix];
                renderDonut(`${prefix}-repaired-chart`,    d.repaired);
                renderSeverityBar(`${prefix}-severity-chart`, d.severity);
                renderArea(`${prefix}-per-year-chart`,    d.perYear, accent);
                renderHBar(`${prefix}-finding-chart`,     d.findings,   '#6f42c1');
                renderHBar(`${prefix}-programmer-chart`,  d.programmer, '#0d6efd');
                renderHBar(`${prefix}-app-chart`,         d.app,        '#198754');
            });
        });
    </script>
@endpush