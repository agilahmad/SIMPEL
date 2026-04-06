@php
    $belum   = $data['repaired_status'][\App\Enums\RepairedStat::Belum->value]   ?? 0;
    $proses  = $data['repaired_status'][\App\Enums\RepairedStat::Proses->value]  ?? 0;
    $selesai = $data['repaired_status'][\App\Enums\RepairedStat::Selesai->value] ?? 0;
    $showReporter = $showReporter ?? false;
@endphp

<p class="fs-11 fw-semibold text-uppercase text-muted mb-3" style="letter-spacing:.8px">Ringkasan</p>
<div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full border-start border-primary border-3">
            <div class="card-body">
                <div class="hstack justify-content-between">
                    <div>
                        <p class="fs-12 text-muted mb-1">Total {{ $label }}</p>
                        <h4 class="fw-bolder mb-0">{{ $data['total'] ?? 0 }}</h4>
                    </div>
                    <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded-circle">
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
                        <h4 class="fw-bolder text-danger mb-0">{{ $data['critical_unfixed'] ?? 0 }}</h4>
                    </div>
                    <div class="avatar-text avatar-lg bg-soft-danger text-danger rounded-circle">
                        <i class="feather-alert-octagon fs-4"></i>
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
                        <h4 class="fw-bolder text-warning mb-0">{{ $proses }}</h4>
                    </div>
                    <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded-circle">
                        <i class="feather-clock fs-4"></i>
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
                        <p class="fs-12 text-muted mb-1">Selesai Diperbaiki</p>
                        <h4 class="fw-bolder text-success mb-0">{{ $selesai }}</h4>
                    </div>
                    <div class="avatar-text avatar-lg bg-soft-success text-success rounded-circle">
                        <i class="feather-check-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<p class="fs-11 fw-semibold text-uppercase text-muted mb-3 mt-3" style="letter-spacing:.8px">Visualisasi Data</p>
<div class="row">
    <div class="col-lg-4">
        <div class="card stretch stretch-full">
            <div class="card-header"><h5 class="card-title">Status Perbaikan</h5></div>
            <div class="card-body custom-card-action"><div id="{{ $prefix }}-repaired-chart"></div></div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card stretch stretch-full">
            <div class="card-header"><h5 class="card-title">Distribusi Severity</h5></div>
            <div class="card-body custom-card-action"><div id="{{ $prefix }}-severity-chart"></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card stretch stretch-full">
            <div class="card-header"><h5 class="card-title">Jumlah Per Tahun</h5></div>
            <div class="card-body custom-card-action"><div id="{{ $prefix }}-per-year-chart"></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card stretch stretch-full">
            <div class="card-header"><h5 class="card-title">Jenis Temuan Terbanyak</h5></div>
            <div class="card-body custom-card-action"><div id="{{ $prefix }}-finding-chart"></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card stretch stretch-full">
            <div class="card-header"><h5 class="card-title">Top Programmer</h5></div>
            <div class="card-body custom-card-action"><div id="{{ $prefix }}-programmer-chart"></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card stretch stretch-full">
            <div class="card-header"><h5 class="card-title">Top Aplikasi</h5></div>
            <div class="card-body custom-card-action"><div id="{{ $prefix }}-app-chart"></div></div>
        </div>
    </div>
</div>

<p class="fs-11 fw-semibold text-uppercase text-muted mb-3 mt-3" style="letter-spacing:.8px">Data Terbaru</p>
<div class="card stretch stretch-full">
    <div class="card-header">
        <h5 class="card-title">5 {{ $label }} Terbaru</h5>
        <div class="card-header-action">
            <a href="{{ route('incidents.index', ['type' => $incidentType]) }}" class="btn btn-light-brand btn-sm">View All</a>
        </div>
    </div>
    <div class="card-body custom-card-action p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Aplikasi</th>
                        @if($showReporter)<th>Pelapor</th>@endif
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['latest'] as $incident)
                        <tr>
                            <td><code class="fs-12 text-primary">{{ $incident->ticket_code }}</code></td>
                            <td class="fw-semibold fs-13">{{ $incident->application->application_name ?? $incident->application_name_input ?? '-' }}</td>
                            @if($showReporter)<td class="fs-12 text-muted">{{ $incident->reporter_name ?? '-' }}</td>@endif
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
                            <td colspan="{{ $showReporter ? 7 : 6 }}" class="text-center text-muted py-5">
                                <i class="feather-inbox fs-1 d-block mb-2"></i>Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
