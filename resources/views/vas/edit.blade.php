@extends('layouts.main')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
    <style>
        .nxl-header { z-index: 9999 !important; }
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
                        <h5 class="m-b-10">Edit {{ auth()->user()->isProgrammer() ? 'Perbaikan' : 'Pentest' }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pentests.index') }}">Pentest</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pentests.show', $pentest) }}">Detail</a></li>
                        <li class="breadcrumb-item">Edit</li>
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
                            <a href="{{ route('vas.show', $pentest) }}" class="btn btn-light-brand">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </a>
                            <button type="submit" form="formPentest" class="btn btn-primary">
                                <i class="feather-save me-2"></i>
                                <span>Simpan</span>
                            </button>
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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="feather-alert-circle me-2"></i>
                        <strong>Terdapat kesalahan pada form.</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="formPentest" action="{{ route('vas.update', $pentest) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card stretch stretch-full mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Pentest</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-4">
                                <label class="form-label fw-semibold fs-14">
                                    Aplikasi <span class="text-danger">*</span>
                                </label>
                                @if (auth()->user()->isProgrammer())
                                    <input type="hidden" name="application_id" value="{{ $pentest->application_id }}">
                                    <input type="text" class="form-control bg-light" value="{{ $pentest->application->application_name }}" disabled>
                                @else
                                    <select class="form-select @error('application_id') is-invalid @enderror" name="application_id" id="applicationSelect" required>
                                        <option value="">— Pilih Aplikasi —</option>
                                        @foreach ($applications as $app)
                                            <option value="{{ $app->id }}" {{ old('application_id', $pentest->application_id) == $app->id ? 'selected' : '' }}>
                                                {{ $app->application_name }}{{ $app->programmer ? ' (Programmer: ' . $app->programmer->name . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('application_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Tanggal Pentest <span class="text-danger">*</span>
                                    </label>
                                    @if (auth()->user()->isProgrammer())
                                        <input type="hidden" name="pentest_date" value="{{ $pentest->pentest_date->format('Y-m-d') }}">
                                        <input type="date" class="form-control bg-light" value="{{ $pentest->pentest_date->format('Y-m-d') }}" disabled>
                                    @else
                                        <input type="date" class="form-control @error('pentest_date') is-invalid @enderror"
                                            name="pentest_date"
                                            value="{{ old('pentest_date', $pentest->pentest_date->format('Y-m-d')) }}" required>
                                        @error('pentest_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Tanggal Perbaikan
                                        <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                                    </label>
                                    @if (auth()->user()->isProgrammer())
                                        <input type="date" class="form-control bg-light" value="{{ $pentest->repaired_date?->format('Y-m-d') }}" disabled>
                                    @else
                                        <input type="date" class="form-control @error('repaired_date') is-invalid @enderror"
                                            name="repaired_date"
                                            value="{{ old('repaired_date', $pentest->repaired_date?->format('Y-m-d')) }}">
                                        @error('repaired_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            @if (!auth()->user()->isProgrammer())
                                <div class="row g-4 mb-4">
                                    <div class="col-sm-6">
                                        <label class="form-label fw-semibold fs-14">
                                            Status Perbaikan <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('repaired_status') is-invalid @enderror" name="repaired_status" required>
                                            <option value="">— Pilih Status —</option>
                                            @foreach ($status as $stat)
                                                <option value="{{ $stat->value }}" {{ old('repaired_status', $pentest->repaired_status?->value) === $stat->value ? 'selected' : '' }}>
                                                    {{ $stat->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('repaired_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-semibold fs-14">
                                            Link
                                            <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                                        </label>
                                        <input type="url" class="form-control @error('link') is-invalid @enderror"
                                            name="link"
                                            value="{{ old('link', $pentest->link) }}"
                                            placeholder="https://example.com/laporan">
                                        @error('link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="repaired_status" value="{{ $pentest->repaired_status?->value }}">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold fs-14">Link
                                        <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                                    </label>
                                    <input type="url" class="form-control @error('link') is-invalid @enderror"
                                        name="link"
                                        value="{{ old('link', $pentest->link) }}"
                                        placeholder="https://example.com/laporan">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                        </div>
                    </div>

                    @if (!auth()->user()->isProgrammer())
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Daftar Kerentanan</h5>
                                <div class="card-header-action">
                                    <a href="#" class="btn btn-primary btn-sm" id="addVulnerability">
                                        <i class="feather-plus me-2"></i>Tambah Kerentanan
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="vulnerabilityContainer">
                                    @foreach ($pentest->vulnerability as $i => $vuln)
                                        @php
                                            $vulnSeverity = $vuln->severity instanceof \App\Enums\Severity ? $vuln->severity->value : $vuln->severity;
                                        @endphp
                                        <div class="border border-dashed border-gray-5 rounded p-4 {{ !$loop->last ? 'mb-4' : 'mb-0' }}" data-index="{{ $i }}">
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <h6 class="fw-semibold mb-0">Kerentanan #{{ $i + 1 }}</h6>
                                                <a href="#" class="btn btn-danger btn-sm remove-vulnerability {{ $pentest->vulnerability->count() === 1 ? 'd-none' : '' }}">
                                                    <i class="feather-trash-2 me-2"></i>Hapus
                                                </a>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-semibold fs-14">Nama Kerentanan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    name="vulnerability[{{ $i }}][vulnerability_name]"
                                                    value="{{ old('vulnerability.' . $i . '.vulnerability_name', $vuln->vulnerability_name) }}"
                                                    placeholder="Contoh: SQL Injection, XSS, CSRF..." required>
                                            </div>
                                            <div class="row g-4 mb-0">
                                                <div class="col-sm-12">
                                                    <label class="form-label fw-semibold fs-14">Severity <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="vulnerability[{{ $i }}][severity]" required>
                                                        <option value="">— Pilih Severity —</option>
                                                        @foreach (['informational', 'low', 'medium', 'high', 'critical'] as $sev)
                                                            <option value="{{ $sev }}" {{ old('vulnerability.' . $i . '.severity', $vulnSeverity) === $sev ? 'selected' : '' }}>
                                                                {{ ucfirst($sev) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <a href="{{ route('vas.show', $pentest) }}" class="btn btn-light-brand">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="feather-save me-2"></i>Simpan Pentest
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Daftar Kerentanan</h5>
                            </div>
                            <div class="card-body">
                                @forelse($pentest->vulnerability as $i => $vuln)
                                    @php
                                        $vulnSeverity = $vuln->severity instanceof \App\Enums\Severity ? $vuln->severity->value : $vuln->severity;
                                        $sevColors = [
                                            'informational' => 'bg-soft-info text-info',
                                            'low'           => 'bg-soft-success text-success',
                                            'medium'        => 'bg-soft-warning text-warning',
                                            'high'          => 'bg-soft-danger text-danger',
                                            'critical'      => 'bg-danger text-white',
                                        ];
                                        $sevColor = $sevColors[$vulnSeverity] ?? 'bg-soft-secondary text-secondary';
                                    @endphp
                                    <div class="border border-dashed border-gray-5 rounded p-4 {{ !$loop->last ? 'mb-4' : 'mb-0' }}">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="fw-semibold mb-0">Kerentanan #{{ $i + 1 }}</h6>
                                            <span class="badge {{ $sevColor }} fs-12">{{ ucfirst($vulnSeverity) }}</span>
                                        </div>
                                        <p class="mb-0 text-muted fs-14">{{ $vuln->vulnerability_name }}</p>
                                    </div>
                                @empty
                                    <p class="text-muted text-center py-3 mb-0">Belum ada kerentanan tercatat.</p>
                                @endforelse
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <a href="{{ route('pentests.show', $pentest) }}" class="btn btn-light-brand">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="feather-save me-2"></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                </form>
            </div>
        </div>
        @include('layouts.footer')
    </main>
@endsection

@push('js')
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            function initSelect2OnElement(el) {
                if ($(el).data('select2')) $(el).select2('destroy');
                $(el).select2({ dropdownParent: $('body'), width: '100%' });
            }

            $('select').each(function () { initSelect2OnElement(this); });

            @if (!auth()->user()->isProgrammer())
                document.querySelectorAll('.remove-vulnerability').forEach(function (btn) {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        btn.closest('[data-index]').remove();
                        renumberVulnerabilities();
                    });
                });

                let vulnerabilityIndex = {{ $pentest->vulnerability->count() }};

                $('#addVulnerability').on('click', function (e) {
                    e.preventDefault();
                    const index = vulnerabilityIndex++;
                    const container = document.getElementById('vulnerabilityContainer');
                    const prev = container.lastElementChild;
                    if (prev) { prev.classList.remove('mb-0'); prev.classList.add('mb-4'); }

                    const item = document.createElement('div');
                    item.classList.add('border', 'border-dashed', 'border-gray-5', 'rounded', 'p-4', 'mb-0');
                    item.dataset.index = index;
                    item.innerHTML = `
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-semibold mb-0">Kerentanan #${index + 1}</h6>
                            <a href="#" class="btn btn-danger btn-sm remove-vulnerability">
                                <i class="feather-trash-2 me-2"></i>Hapus
                            </a>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">Nama Kerentanan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"
                                   name="vulnerability[${index}][vulnerability_name]"
                                   placeholder="Contoh: SQL Injection, XSS, CSRF..." required>
                        </div>
                        <div class="row g-4 mb-0">
                            <div class="col-sm-12">
                                <label class="form-label fw-semibold fs-14">Severity <span class="text-danger">*</span></label>
                                <select class="form-select" name="vulnerability[${index}][severity]" required>
                                    <option value="">— Pilih Severity —</option>
                                    <option value="informational">Informational</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>
                        </div>`;

                    item.querySelectorAll('select').forEach(function (el) { initSelect2OnElement(el); });
                    item.querySelector('.remove-vulnerability').addEventListener('click', function (e) {
                        e.preventDefault();
                        item.remove();
                        renumberVulnerabilities();
                    });

                    container.appendChild(item);
                    renumberVulnerabilities();
                });

                function renumberVulnerabilities() {
                    const items = document.querySelectorAll('#vulnerabilityContainer > div');
                    items.forEach(function (item, i) {
                        item.querySelector('h6').textContent = `Kerentanan #${i + 1}`;
                        const btn = item.querySelector('.remove-vulnerability');
                        if (btn) btn.classList.toggle('d-none', items.length === 1);
                        item.classList.toggle('mb-4', i < items.length - 1);
                        item.classList.toggle('mb-0', i === items.length - 1);
                    });
                }
            @endif
        });
    </script>
@endpush