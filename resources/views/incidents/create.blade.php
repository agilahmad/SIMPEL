@extends('layouts.main')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">

    <style>
        .nxl-header {
            z-index: 9999 !important;
        }

        .select2-container {
            z-index: 1 !important;
        }

        .select2-container--open .select2-dropdown {
            z-index: 1 !important;
        }
    </style>
@endpush

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Tambah Insiden</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incidents.index') }}">Insiden</a></li>
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
                            <a href="{{ route('incidents.index') }}" class="btn btn-light-brand">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </a>
                            <button type="submit" form="formIncident" class="btn btn-primary">
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
                        <strong>Terdapat kesalahan pada form:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="formIncident" action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Informasi Insiden</h5>
                        </div>
                        <div class="card-body">

                            {{-- Type + Nama Pelapor --}}
                            <div class="row g-4 mb-4">
                                @if (auth()->user()->isUser())
                                    <input type="hidden" name="type" value="community_report">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold fs-14">
                                            Nama Pelapor <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('reporter_name') is-invalid @enderror"
                                            name="reporter_name" value="{{ old('reporter_name') }}"
                                            placeholder="Nama pelapor masyarakat" required>
                                        @error('reporter_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @else
                                    @php
                                        $selectedType = old('type', '');
                                        if (!$selectedType && request('type') === 'potential_incident') {
                                            $selectedType = 'potential_incident';
                                        }
                                        if (!$selectedType && request('type') === 'community_report') {
                                            $selectedType = 'community_report';
                                        }
                                        $isLaporanMasyarakat = $selectedType === 'community_report';
                                    @endphp
                                    <div class="col-12">
                                        <label class="form-label fw-semibold fs-14">
                                            Jenis Insiden <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('type') is-invalid @enderror" name="type"
                                            id="typeSelect" required>
                                            <option value="">— Pilih Jenis —</option>
                                            <option value="potential_incident"
                                                {{ $selectedType === 'potential_incident' ? 'selected' : '' }}>
                                                Potensi Insiden
                                            </option>
                                            <option value="community_report"
                                                {{ $selectedType === 'community_report' ? 'selected' : '' }}>
                                                Laporan Masyarakat
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 {{ $isLaporanMasyarakat ? '' : 'd-none' }}" id="reporterNameField">
                                        <label class="form-label fw-semibold fs-14">
                                            Nama Pelapor <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('reporter_name') is-invalid @enderror"
                                            name="reporter_name" id="reporterNameInput" value="{{ old('reporter_name') }}"
                                            placeholder="Nama pelapor masyarakat"
                                            {{ $isLaporanMasyarakat ? 'required' : '' }}>
                                        @error('reporter_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>

                            {{-- Aplikasi --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold fs-14">
                                    Aplikasi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('application_id') is-invalid @enderror"
                                    name="application_id" id="applicationSelect" required>
                                    <option value="">— Pilih Aplikasi —</option>
                                    @foreach ($applications as $app)
                                        <option value="{{ $app->id }}" data-pic-id="{{ $app->programmer->id ?? '' }}"
                                            {{ old('application_id') == $app->id ? 'selected' : '' }}>
                                            {{ $app->application_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('application_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PIC --}}
                            @if (auth()->user()->isAdmin())
                                <div class="mb-4">
                                    <label class="form-label fw-semibold fs-14">
                                        Override Programmer
                                        <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                                    </label>
                                    <select class="form-select @error('pic_id') is-invalid @enderror" name="pic_id"
                                        id="picSelect">
                                        <option value="">— Auto Assign —</option>
                                        @foreach (\App\Models\User::where('role', 'programmer')->get() as $prog)
                                            <option value="{{ $prog->id }}"
                                                {{ old('pic_id') == $prog->id ? 'selected' : '' }}>
                                                {{ $prog->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="pic_id" id="picHidden" value="{{ old('pic_id') }}">
                            @endif

                            {{-- Nama Kerentanan --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold fs-14">
                                    Nama Kerentanan <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('vulnerability_name') is-invalid @enderror"
                                    name="vulnerability_name" value="{{ old('vulnerability_name') }}"
                                    placeholder="Contoh: SQL Injection, XSS, CSRF..." required>
                                @error('vulnerability_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold fs-14">
                                    Upload Bukti <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control @error('xxx') is-invalid @enderror"
                                    name="evidences[]" value="xx" required>
                                @error('xxx')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Severity + Tanggal --}}
                            <div class="row g-4 mb-0">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Severity <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('severity') is-invalid @enderror" name="severity"
                                        required>
                                        <option value="">— Pilih Severity —</option>
                                        @foreach (['informational', 'low', 'medium', 'high', 'critical'] as $sev)
                                            <option value="{{ $sev }}"
                                                {{ old('severity') === $sev ? 'selected' : '' }}>
                                                {{ ucfirst($sev) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('severity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold fs-14">
                                        Tanggal Pelaporan <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                        class="form-control @error('reporting_date') is-invalid @enderror"
                                        name="reporting_date" value="{{ old('reporting_date', date('Y-m-d')) }}"
                                        required>
                                    @error('reporting_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('incidents.index') }}" class="btn btn-light-brand">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-2"></i>Simpan Insiden
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
            $('select').each(function() {
                $(this).select2({
                    dropdownParent: $('body'),
                    width: '100%'
                });
            });

            @if (!auth()->user()->isUser())
                $('#typeSelect').on('change', function() {
                    const isMasyarakat = $(this).val() === 'community_report';
                    $('#reporterNameField').toggleClass('d-none', !isMasyarakat);
                    $('#reporterNameInput').prop('required', isMasyarakat);
                    if (!isMasyarakat) $('#reporterNameInput').val('');
                });
            @endif

            $('#applicationSelect').on('change', function() {
                const picId = $(this).find(':selected').data('pic-id') || '';
                @if (auth()->user()->isAdmin())
                    $('#picSelect').val(picId).trigger('change');
                @else
                    $('#picHidden').val(picId);
                @endif
            });

            if ($('#applicationSelect').val()) {
                $('#applicationSelect').trigger('change');
            }
        });
    </script>
@endpush
