@extends('layouts.main')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
    <style>

        .select2-container { z-index: 1 !important; }
        .select2-container--open .select2-dropdown { z-index: 1 !important; }
    </style>
@endpush

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Detail Insiden</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incidents.index') }}">Insiden</a></li>
                        <li class="breadcrumb-item">{{ $incident->ticket_code }}</li>
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
                            <a href="{{ route('incidents.index') }}" class="btn btn-light-brand">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
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
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="feather-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="feather-x-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @php
                    $repairedVal = $incident->repaired_status instanceof \App\Enums\RepairedStat
                        ? $incident->repaired_status->value
                        : $incident->repaired_status;
                    $typeVal = $incident->type instanceof \App\Enums\IncidentType
                        ? $incident->type->value
                        : $incident->type;
                @endphp

                <div class="row">

                    {{-- CARD 1: Informasi + Bukti --}}
                    <div class="col-xxl-8 col-lg-7">
                        <div class="card stretch stretch-full mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Informasi Insiden</h5>
                                <div class="card-header-action">
                                    <span class="badge bg-soft-primary text-primary fs-12 px-3 py-2">
                                        <i class="feather-hash me-1"></i>{{ $incident->ticket_code }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">

                                <p class="fs-11 fw-bold text-uppercase text-muted mb-3" style="letter-spacing:.8px">
                                    <i class="feather-info me-1"></i> Identitas
                                </p>
                                <div class="row g-3 mb-4 pb-4 border-bottom">
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Aplikasi</p>
                                            <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->application->application_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Jenis</p>
                                            @if ($typeVal === 'potential_incident')
                                                <span class="badge bg-soft-warning text-warning">Potensi Insiden</span>
                                            @else
                                                <span class="badge bg-soft-info text-info">Laporan Masyarakat</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Nama Kerentanan</p>
                                            <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->vulnerability_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Severity</p>
                                            @include('partials.severity-badge', ['severity' => $incident->severity])
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Tanggal Pelaporan</p>
                                            <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->reporting_date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Tanggal Perbaikan</p>
                                            <p class="fs-13 fw-bold mb-0 text-dark">
                                                {{ $incident->repaired_date ? $incident->repaired_date->format('d M Y') : '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <p class="fs-11 fw-bold text-uppercase text-muted mb-3" style="letter-spacing:.8px">
                                    <i class="feather-activity me-1"></i> Detail Tindak Lanjut
                                </p>
                                <div class="row g-3 mb-4 pb-4 border-bottom">
                                    @if ($incident->link)
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3 bg-soft-light border">
                                                <p class="fs-11 fw-semibold text-uppercase text-muted mb-2" style="letter-spacing:.5px">Link Referensi</p>
                                                <a href="{{ $incident->link }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary" style="border-radius:8px; font-weight:500;">
                                                    <i class="feather-external-link me-1"></i>Lihat Link
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Status Perbaikan</p>
                                            @include('partials.pentest-status-badge', ['status' => $incident->repaired_status])
                                        </div>
                                    </div>
                                </div>

                                <p class="fs-11 fw-bold text-uppercase text-muted mb-3" style="letter-spacing:.8px">
                                    <i class="feather-users me-1"></i> Personil
                                </p>
                                <div class="row g-3 mb-4 pb-4 border-bottom">
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-2" style="letter-spacing:.5px">
                                                {{ $typeVal === 'community_report' ? 'Nama Pelapor' : 'Dilaporkan Oleh' }}
                                            </p>
                                            @if ($typeVal === 'community_report')
                                                <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->reporter_name ?? '—' }}</p>
                                            @else
                                                <div class="hstack gap-2">
                                                    <div class="avatar-text avatar-sm bg-soft-primary text-primary rounded-circle fs-11">
                                                        {{ strtoupper(substr($incident->creator->name ?? '?', 0, 1)) }}
                                                    </div>
                                                    <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->creator->name ?? '—' }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-2" style="letter-spacing:.5px">Programmer</p>
                                            @if ($incident->pic)
                                                <div class="hstack gap-2">
                                                    <div class="avatar-text avatar-sm bg-soft-success text-success rounded-circle fs-11">
                                                        {{ strtoupper(substr($incident->pic->name, 0, 1)) }}
                                                    </div>
                                                    <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->pic->name }}</p>
                                                </div>
                                            @else
                                                <p class="fs-13 text-muted fst-italic mb-0">Belum ditugaskan</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-2" style="letter-spacing:.5px">Dibuat Oleh</p>
                                            <div class="hstack gap-2">
                                                <div class="avatar-text avatar-sm bg-soft-teal text-teal rounded-circle fs-11">
                                                    {{ strtoupper(substr($incident->creator->name ?? '?', 0, 1)) }}
                                                </div>
                                                <p class="fs-13 fw-bold mb-0 text-dark">{{ $incident->creator->name ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION: Bukti Perbaikan --}}
                                <p class="fs-11 fw-bold text-uppercase text-muted mb-3" style="letter-spacing:.8px">
                                    <i class="feather-file-text me-1"></i> Bukti Perbaikan
                                </p>

                                {{-- Admin: tabel review --}}
                                @if (auth()->user()->isAdmin())
                                    <div class="table-responsive mb-3">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="fs-12">#</th>
                                                    <th class="fs-12">File</th>
                                                    <th class="fs-12">Diupload Oleh</th>
                                                    <th class="fs-12">Status</th>
                                                    <th class="fs-12">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($incident->evidences as $evidence)
                                                    <tr>
                                                        <td class="fs-12 text-muted">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $evidence->file_path) }}"
                                                                target="_blank"
                                                                class="d-flex align-items-center gap-2 text-primary fw-semibold text-decoration-none">
                                                                <i class="feather-image fs-14"></i>
                                                                <span class="text-truncate" style="max-width:160px;">{{ $evidence->file_name }}</span>
                                                            </a>
                                                        </td>
                                                        <td class="fs-12 text-muted">{{ $evidence->uploader->name ?? '-' }}</td>
                                                        <td>
                                                            @if ($evidence->isPending())
                                                                <span class="badge bg-soft-warning text-warning">Pending</span>
                                                            @elseif ($evidence->isApproved())
                                                                <span class="badge bg-soft-success text-success">Disetujui</span>
                                                            @elseif ($evidence->isRejected())
                                                                <span class="badge bg-soft-danger text-danger" title="{{ $evidence->rejection_note }}">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($evidence->isPending())
                                                                <div class="d-flex gap-2">
                                                                    <form action="{{ route('evidences.approve', $evidence) }}" method="POST">
                                                                        @csrf @method('PATCH')
                                                                        <button type="submit" class="btn btn-sm btn-success"
                                                                            onclick="return confirm('Setujui bukti ini?')">
                                                                            <i class="feather-check me-1"></i>Setujui
                                                                        </button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modalReject{{ $evidence->id }}">
                                                                        <i class="feather-x me-1"></i>Tolak
                                                                    </button>
                                                                </div>
                                                            @elseif ($evidence->isApproved())
                                                                <span class="fs-12 text-muted">—</span>
                                                            @elseif ($evidence->isRejected())
                                                                <span class="fs-12 text-danger" title="{{ $evidence->rejection_note }}">
                                                                    {{ Str::limit($evidence->rejection_note, 40) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">
                                                            <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                            Belum ada bukti perbaikan diupload
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {{-- Programmer: tabel status bukti + tombol upload --}}
                                @if (auth()->user()->isProgrammer() && $incident->pic_id === auth()->id())
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="fs-13 fw-semibold text-dark">Bukti Perbaikan Saya</span>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalUploadEvidence">
                                            <i class="feather-upload me-1"></i> Upload Bukti Baru
                                        </button>
                                    </div>

                                    @if ($incident->evidences->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="fs-12">#</th>
                                                        <th class="fs-12">File</th>
                                                        <th class="fs-12">Status</th>
                                                        <th class="fs-12">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($incident->evidences as $evidence)
                                                        <tr>
                                                            <td class="fs-12 text-muted">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/' . $evidence->file_path) }}"
                                                                    target="_blank"
                                                                    class="d-flex align-items-center gap-2 text-primary fw-semibold text-decoration-none">
                                                                    <i class="feather-image fs-14"></i>
                                                                    <span class="text-truncate" style="max-width:160px;">{{ $evidence->file_name }}</span>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if ($evidence->isPending())
                                                                    <span class="badge bg-soft-warning text-warning">Menunggu Review</span>
                                                                @elseif ($evidence->isApproved())
                                                                    <span class="badge bg-soft-success text-success">Disetujui</span>
                                                                @elseif ($evidence->isRejected())
                                                                    <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                                @endif
                                                            </td>
                                                            <td class="fs-12">
                                                                @if ($evidence->isApproved())
                                                                    <span class="text-muted">Disetujui oleh {{ $evidence->approver->name ?? '-' }}</span>
                                                                @elseif ($evidence->isRejected())
                                                                    <span class="text-danger">
                                                                        <i class="feather-alert-circle me-1"></i>
                                                                        {{ $evidence->rejection_note ?? 'Tidak ada keterangan' }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="feather-inbox fs-1 d-block mb-2"></i>
                                            Belum ada bukti perbaikan diupload
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: Sidebar --}}
                    <div class="col-xxl-4 col-lg-5">

                        @if (auth()->user()->isAdmin())
                            <div class="card stretch stretch-full mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="feather-refresh-cw me-2 text-primary"></i>Update Status
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('incidents.update', $incident) }}">
                                        @csrf @method('PATCH')
                                        <div class="mb-3">
                                            <label class="form-label fs-12 fw-semibold">Status Perbaikan</label>
                                            <select class="form-select" name="repaired_status" data-select2-selector="default">
                                                <option value="belum_dilakukan" {{ $repairedVal === 'belum_dilakukan' ? 'selected' : '' }}>Belum Dilakukan</option>
                                                <option value="dalam_proses" {{ $repairedVal === 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                                                <option value="selesai" {{ $repairedVal === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fs-12 fw-semibold">
                                                Link <span class="text-danger">*</span>
                                            </label>
                                            <input type="url" name="link"
                                                class="form-control @error('link') is-invalid @enderror"
                                                value="{{ old('link', $incident->link ?? '') }}"
                                                placeholder="https://example.com">
                                            @error('link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fs-12 fw-semibold">Override Programmer</label>
                                            <select class="form-select" name="pic_id" data-select2-selector="default">
                                                <option value="">-- Pilih PIC --</option>
                                                @foreach ($programmers as $programmer)
                                                    <option value="{{ $programmer->id }}" {{ $incident->pic_id == $programmer->id ? 'selected' : '' }}>
                                                        {{ $programmer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fs-12 fw-semibold">Tanggal Perbaikan</label>
                                            <input type="date" class="form-control" name="repaired_date"
                                                value="{{ $incident->repaired_date?->format('Y-m-d') }}">
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather-save me-2"></i>Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="card stretch stretch-full mb-4">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="feather-clock me-2 text-muted"></i>Ringkasan
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                        <span class="fs-12 text-muted">Tiket</span>
                                        <code class="fs-12 text-primary">{{ $incident->ticket_code }}</code>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                        <span class="fs-12 text-muted">Severity</span>
                                        @include('partials.severity-badge', ['severity' => $incident->severity])
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                        <span class="fs-12 text-muted">Status Perbaikan</span>
                                        @include('partials.pentest-status-badge', ['status' => $incident->repaired_status])
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                        <span class="fs-12 text-muted">Dilaporkan</span>
                                        <span class="fs-12 fw-semibold">{{ $incident->reporting_date->format('d M Y') }}</span>
                                    </li>
                                    @if ($incident->link)
                                        <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                            <span class="fs-12 text-muted">Link</span>
                                            <a href="{{ $incident->link }}" target="_blank" class="fs-12 text-primary text-decoration-none">
                                                <i class="feather-external-link me-1"></i>Lihat Link
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if (auth()->user()->isAdmin())
                            <div class="card stretch stretch-full border border-danger">
                                <div class="card-header border-bottom border-danger">
                                    <h5 class="card-title text-danger">
                                        <i class="feather-alert-triangle me-2"></i>Zona Bahaya
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="fs-12 text-muted mb-4">
                                        Tindakan berikut bersifat <strong>permanen</strong> dan tidak dapat dibatalkan.
                                    </p>
                                    <form method="POST" action="{{ route('incidents.destroy', $incident) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus insiden {{ $incident->ticket_code }}? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="feather-trash-2 me-2"></i>Hapus Insiden
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </main>

    {{-- Modal Upload Bukti — Programmer --}}
    @if (auth()->user()->isProgrammer() && $incident->pic_id === auth()->id())
        <div class="modal fade" id="modalUploadEvidence" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('evidences.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Bukti Perbaikan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label class="form-label fw-semibold">
                                    File <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                    class="form-control @error('files') is-invalid @enderror @error('files.*') is-invalid @enderror"
                                    name="files[]" multiple required>
                                <div class="form-text text-muted">Format: JPG, PNG, PDF. DOCS. dll. Maks 5MB per file.</div>
                                @error('files')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('files.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-brand" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-upload me-1"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Reject — Admin --}}
    @if (auth()->user()->isAdmin())
        @foreach ($incident->evidences as $evidence)
            @if ($evidence->isPending())
                <div class="modal fade" id="modalReject{{ $evidence->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('incidents.evidences.reject', [$incident, $evidence]) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak Bukti Perbaikan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted fs-13 mb-3">
                                        File: <strong>{{ $evidence->file_name }}</strong>
                                    </p>
                                    <div class="mb-1">
                                        <label class="form-label fw-semibold">
                                            Alasan Penolakan <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" name="rejection_note" rows="3"
                                            placeholder="Tuliskan alasan penolakan..." required maxlength="500"></textarea>
                                        <div class="form-text text-muted">Maksimal 500 karakter</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-brand" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="feather-x me-1"></i>Tolak Bukti
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

@endsection

@push('js')
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('[data-select2-selector="default"]').each(function () {
                $(this).select2({ dropdownParent: $('body'), width: '100%' });
            });
        });
    </script>
@endpush
