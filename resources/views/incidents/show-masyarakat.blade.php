@extends('layouts.main')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Laporan Masyarakat</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('incidents.masyarakat') }}">Portal Publik</a></li>
                    <li class="breadcrumb-item">{{ $item['ticket_code'] }}</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <a href="{{ route('incidents.masyarakat') }}" class="btn btn-light-brand">
                    <i class="feather-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="main-content">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="feather-x-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
                <i class="feather-alert-triangle fs-16"></i>
                <span class="fs-13">Laporan ini belum disimpan ke sistem. Pilih aplikasi yang sesuai lalu klik <strong>Simpan ke Sistem</strong>.</span>
            </div>

            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="card stretch stretch-full mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Laporan</h5>
                            <div class="card-header-action">
                                <span class="badge bg-soft-primary text-primary fs-12 px-3 py-2">
                                    <i class="feather-hash me-1"></i>{{ $item['ticket_code'] }}
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
                                        <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Aplikasi (dari pelapor)</p>
                                        <p class="fs-13 fw-bold mb-0 text-dark">{{ $item['application_name'] ?? '—' }}</p>
                                        <span class="badge bg-soft-warning text-warning mt-1" style="font-size:10px;">Perlu diverifikasi</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-soft-light border">
                                        <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Jenis</p>
                                        <span class="badge bg-soft-info text-info">Laporan Masyarakat</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-soft-light border">
                                        <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Nama Kerentanan</p>
                                        <p class="fs-13 fw-bold mb-0 text-dark">{{ $item['vulnerability_name'] }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-soft-light border">
                                        <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Severity</p>
                                        @include('partials.severity-badge', ['severity' => $item['severity']])
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-soft-light border">
                                        <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Tanggal Pelaporan</p>
                                        <p class="fs-13 fw-bold mb-0 text-dark">
                                            {{ \Carbon\Carbon::parse($item['reporting_date'])->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-soft-light border">
                                        <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Nama Pelapor</p>
                                        <p class="fs-13 fw-bold mb-0 text-dark">{{ $item['reporter_name'] ?? '—' }}</p>
                                    </div>
                                </div>
                                @if(!empty($item['file_path']))
                                    <div class="col-sm-6">
                                        <div class="p-3 rounded-3 bg-soft-light border h-100">
                                            <p class="fs-11 fw-semibold text-uppercase text-muted mb-2" style="letter-spacing:.5px">File Lampiran</p>
                                            <a href="{{ $item['file_path'] }}" target="_blank"
                                                class="d-flex align-items-center gap-2 text-primary fw-semibold text-decoration-none">
                                                <i class="feather-paperclip fs-14"></i>
                                                <span class="text-truncate">{{ basename(parse_url($item['file_path'], PHP_URL_PATH)) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-lg-5">
                    <div class="card stretch stretch-full mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="feather-save me-2 text-primary"></i>Simpan ke Sistem
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('incidents.masyarakat.save', $item['id']) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fs-12 fw-semibold">
                                        Aplikasi <span class="text-danger">*</span>
                                    </label>
                                    @if(!empty($item['application_name']))
                                        <div class="mb-2 p-2 rounded-2 bg-soft-warning border border-warning-subtle">
                                            <span class="fs-12 text-muted">Input dari pelapor: </span>
                                            <strong class="fs-12">{{ $item['application_name'] }}</strong>
                                        </div>
                                    @endif
                                    <select class="form-select @error('application_id') is-invalid @enderror"
                                        name="application_id" id="applicationSelect">
                                        <option value="">-- Pilih Aplikasi --</option>
                                        @foreach($applications as $app)
                                            <option value="{{ $app->id }}"
                                                data-programmer-id="{{ $app->programmer_id }}"
                                                data-programmer-name="{{ $app->programmer->name ?? 'Belum ada' }}"
                                                {{ old('application_id') == $app->id ? 'selected' : '' }}>
                                                {{ $app->application_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('application_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 p-3 rounded-3 bg-soft-light border" id="programmerInfo" style="display:none;">
                                    <p class="fs-11 fw-semibold text-uppercase text-muted mb-1" style="letter-spacing:.5px">Programmer yang akan ditugaskan</p>
                                    <div class="hstack gap-2 mt-2">
                                        <div class="avatar-text avatar-sm bg-soft-success text-success rounded-circle fs-11" id="programmerAvatar"></div>
                                        <span class="fs-13 fw-semibold text-dark" id="programmerName"></span>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Simpan laporan ini ke sistem?')">
                                        <i class="feather-save me-2"></i>Simpan ke Sistem
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

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
                                    <code class="fs-12 text-primary">{{ $item['ticket_code'] }}</code>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                    <span class="fs-12 text-muted">Severity</span>
                                    @include('partials.severity-badge', ['severity' => $item['severity']])
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                    <span class="fs-12 text-muted">Dilaporkan</span>
                                    <span class="fs-12 fw-semibold">
                                        {{ \Carbon\Carbon::parse($item['reporting_date'])->format('d M Y') }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                    <span class="fs-12 text-muted">Sumber</span>
                                    <span class="badge bg-soft-info text-info fs-11">Portal Publik</span>
                                </li>
                            </ul>
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
<script>
    document.getElementById('applicationSelect').addEventListener('change', function () {
        var selected = this.options[this.selectedIndex];
        var programmerId   = selected.dataset.programmerId;
        var programmerName = selected.dataset.programmerName;
        var infoBox        = document.getElementById('programmerInfo');
        var nameEl         = document.getElementById('programmerName');
        var avatarEl       = document.getElementById('programmerAvatar');

        if (programmerId && programmerName) {
            nameEl.textContent   = programmerName;
            avatarEl.textContent = programmerName.charAt(0).toUpperCase();
            infoBox.style.display = '';
        } else {
            infoBox.style.display = 'none';
        }
    });
</script>
@endpush