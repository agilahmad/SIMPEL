@extends('layouts.main')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
@endpush

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        {{-- <h5 class="m-b-10">Tambah {{ $type === 'pentest' ? 'Pentest' : 'Vulnerability Assessment' }}</h5> --}}
                        <h5 class="m-b-10">Tambah Vulnerability Assessment</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vas.index') }}">Pentest</a></li>
                        <li class="breadcrumb-item">Tambah</li>
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
                            <a href="{{ route('vas.index') }}" class="btn btn-light-brand">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </a>
                            <button type="submit" form="formVa" class="btn btn-primary">
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

                <form id="formVa" action="{{ route('vas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="vulnerability_assessment}">

                    <div class="card stretch stretch-full mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Vulnerability Assessment</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-4">
                                <label class="form-label fw-semibold fs-14">
                                    Aplikasi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('application_id') is-invalid @enderror"
                                    name="application_id" id="applicationSelect" required>
                                    <option value="">— Pilih Aplikasi —</option>
                                    @foreach ($applications as $app)
                                        <option value="{{ $app->id }}"
                                            {{ old('application_id') == $app->id ? 'selected' : '' }}>
                                            {{ $app->application_name }}{{ $app->programmer ? ' (Programmer: ' . $app->programmer->name . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('application_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Tanggal Pentest <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('pentest_date') is-invalid @enderror"
                                        name="pentest_date" value="{{ old('pentest_date') }}" required>
                                    @error('pentest_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Status Perbaikan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('repaired_status') is-invalid @enderror"
                                        name="repaired_status" required>
                                        <option value="">— Pilih Status —</option>
                                        @foreach ($status as $stat)
                                            <option value="{{ $stat->value }}"
                                                {{ old('repaired_status') === $stat->value ? 'selected' : '' }}>
                                                {{ $stat->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('repaired_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mb-4">

                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Tanggal Perbaikan
                                        <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                                    </label>
                                    <input type="date" class="form-control @error('repaired_date') is-invalid @enderror"
                                        name="repaired_date" value="{{ old('repaired_date') }}">
                                    @error('repaired_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                  <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Link
                                        <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                                    </label>
                                    <input type="url" class="form-control @error('link') is-invalid @enderror"
                                        name="link" value="{{ old('link') }}"
                                        placeholder="https://example.com/laporan">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

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
                                <div class="border border-dashed border-gray-5 rounded p-4 mb-0" data-index="0">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h6 class="fw-semibold mb-0">Kerentanan #1</h6>
                                        <a href="#" class="btn btn-danger btn-sm remove-vulnerability d-none">
                                            <i class="feather-trash-2 me-2"></i>Hapus
                                        </a>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold fs-14">
                                            Nama Kerentanan <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control"
                                            name="vulnerability[0][vulnerability_name]"
                                            value="{{ old('vulnerability.0.vulnerability_name') }}"
                                            placeholder="Contoh: SQL Injection, XSS, CSRF..." required>
                                    </div>
                                    <div class="row g-4 mb-0">
                                        <div class="col-sm-12">
                                            <label class="form-label fw-semibold fs-14">
                                                Severity <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="vulnerability[0][severity]" required>
                                                <option value="">— Pilih Severity —</option>
                                                @foreach (['informational', 'low', 'medium', 'high', 'critical'] as $sev)
                                                    <option value="{{ $sev }}"
                                                        {{ old('vulnerability.0.severity') === $sev ? 'selected' : '' }}>
                                                        {{ ucfirst($sev) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('pentests.index') }}" class="btn btn-light-brand">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-2"></i>Simpan Pentest
                                </button>
                            </div>
                        </div>
                    </div>

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
        $(document).ready(function() {
            const statusOptions = @json(array_map(fn($s) => ['value' => $s->value, 'label' => $s->label()], $status));

            function initSelect2OnElement(el) {
                if ($(el).data('select2')) $(el).select2('destroy');
                $(el).select2({
                    dropdownParent: $('body'),
                    width: '100%'
                });
            }

            $('select').each(function() {
                initSelect2OnElement(this);
            });

            let vulnerabilityIndex = 1;

            $('#addVulnerability').on('click', function(e) {
                e.preventDefault();
                const index = vulnerabilityIndex++;
                const container = document.getElementById('vulnerabilityContainer');

                const prev = container.lastElementChild;
                if (prev) {
                    prev.classList.remove('mb-0');
                    prev.classList.add('mb-4');
                }

                const statusOptionsHtml = statusOptions.map(s =>
                    `<option value="${s.value}">${s.label}</option>`
                ).join('');

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

                item.querySelectorAll('select').forEach(function(el) {
                    initSelect2OnElement(el);
                });

                item.querySelector('.remove-vulnerability').addEventListener('click', function(e) {
                    e.preventDefault();
                    item.remove();
                    renumberVulnerabilities();
                });

                container.appendChild(item);
                renumberVulnerabilities();
            });

            function renumberVulnerabilities() {
                const items = document.querySelectorAll('#vulnerabilityContainer > div');
                items.forEach(function(item, i) {
                    item.querySelector('h6').textContent = `Kerentanan #${i + 1}`;
                    const btn = item.querySelector('.remove-vulnerability');
                    if (btn) btn.classList.toggle('d-none', items.length === 1);
                    item.classList.toggle('mb-4', i < items.length - 1);
                    item.classList.toggle('mb-0', i === items.length - 1);
                });
            }
        });
    </script>
@endpush
