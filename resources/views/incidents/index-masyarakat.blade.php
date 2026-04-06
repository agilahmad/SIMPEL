@extends('layouts.main')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Laporan Masyarakat — Portal Publik</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incidents.index') }}">Insiden</a></li>
                        <li class="breadcrumb-item">Portal Publik</li>
                    </ul>
                </div>
            </div>

            <div class="main-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="feather-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="feather-x-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex align-items-center gap-2 mb-4">
                    <a href="{{ route('incidents.index', request()->only(['type', 'severity'])) }}"
                        class="btn btn-light-brand">
                        <i class="feather-database me-2"></i>Data Internal
                    </a>
                    <a href="{{ route('incidents.index') }}" class="btn btn-primary">
                        <i class="feather-globe me-2"></i>Portal Publik
                    </a>
                </div>

                <div class="alert alert-info d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="feather-info fs-16"></i>
                    <span class="fs-13">Data berikut berasal dari portal publik. Tinjau <strong>Laporan Masyarakat</strong>
                        sekarang.</span>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Tiket / Kerentanan</th>
                                                <th>Aplikasi</th>
                                                <th>Pelapor</th>
                                                <th>Severity</th>
                                                <th>Tanggal</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $index => $item)
                                                <tr>
                                                    <td class="fs-12 text-muted">{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <div
                                                                class="avatar-text avatar-md bg-soft-info text-info rounded">
                                                                <i class="feather-alert-circle"></i>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('incidents.masyarakat.show', $item['id']) }}"
                                                                    class="fw-semibold text-truncate-1-line">
                                                                    {{ $item['vulnerability_name'] }}
                                                                </a>
                                                                <p class="fs-11 text-muted mb-0 mt-1">
                                                                    <code class="fs-11">{{ $item['ticket_code'] }}</code>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-2">
                                                            <div
                                                                class="avatar-text avatar-sm bg-soft-primary text-primary rounded">
                                                                {{ strtoupper(substr($item['application_name'] ?? '?', 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="fs-13 text-truncate-1-line"
                                                                    style="max-width:120px;display:block;">
                                                                    {{ $item['application_name'] ?? '—' }}
                                                                </span>
                                                                <span class="badge bg-soft-warning text-warning"
                                                                    style="font-size:9px;">Belum diverifikasi</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="fs-13">{{ $item['reporter_name'] ?? '—' }}</td>
                                                    <td>
                                                        @include('partials.severity-badge', [
                                                            'severity' => $item['severity'],
                                                        ])
                                                    </td>
                                                    <td class="fs-12 text-muted">
                                                        {{ \Carbon\Carbon::parse($item['reporting_date'])->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('incidents.masyarakat.show', $item['id']) }}"
                                                                class="btn btn-sm btn-light-brand">
                                                                <i class="feather-eye me-1"></i>Detail
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-5">
                                                        <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                        Tidak ada laporan baru dari portal publik
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if ($lastPage > 1)
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <p class="fs-12 text-muted mb-0">
                                        Halaman {{ $currentPage }} dari {{ $lastPage }} — Total {{ $total }}
                                        laporan
                                    </p>
                                    <div class="d-flex gap-2">
                                        @if ($currentPage > 1)
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}"
                                                class="btn btn-sm btn-light-brand">
                                                <i class="feather-chevron-left"></i>
                                            </a>
                                        @endif
                                        @if ($currentPage < $lastPage)
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}"
                                                class="btn btn-sm btn-light-brand">
                                                <i class="feather-chevron-right"></i>
                                            </a>
                                        @endif
                                    </div>
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
