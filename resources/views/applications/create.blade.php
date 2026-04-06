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
                    <h5 class="m-b-10">{{ isset($application) ? 'Edit Aplikasi' : 'Tambah Aplikasi' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Aplikasi</a></li>
                    <li class="breadcrumb-item">{{ isset($application) ? 'Edit' : 'Tambah' }}</li>
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
                        <a href="{{ route('applications.index') }}" class="btn btn-light-brand">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <button type="submit" form="formApplication" class="btn btn-primary">
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
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="feather-alert-circle me-2"></i>
                <strong>Terdapat kesalahan pada form.</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form id="formApplication" method="POST"
                  action="{{ isset($application) ? route('applications.update', $application) : route('applications.store') }}">
                @csrf
                @isset($application) @method('PUT') @endisset

                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Aplikasi</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">
                                Nama Aplikasi <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('application_name') is-invalid @enderror"
                                   name="application_name"
                                   value="{{ old('application_name', $application->application_name ?? '') }}"
                                   placeholder="Masukkan nama aplikasi"
                                   required>
                            @error('application_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold fs-14">
                                Programmer (PIC)
                                <span class="text-muted fs-12 fw-normal ms-1">— opsional</span>
                            </label>
                            <select class="form-select @error('programmer_id') is-invalid @enderror"
                                    name="programmer_id">
                                <option value="">— Pilih Programmer —</option>
                                @foreach($programmers as $programmer)
                                <option value="{{ $programmer->id }}"
                                    {{ old('programmer_id', $application->programmer_id ?? '') == $programmer->id ? 'selected' : '' }}>
                                    {{ $programmer->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('programmer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="fs-12 text-muted mt-2 mb-0">
                                <i class="feather-info me-1"></i>
                                Programmer yang dipilih akan menjadi PIC untuk insiden pada aplikasi ini.
                            </p>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('applications.index') }}" class="btn btn-light-brand">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-save me-2"></i>
                                {{ isset($application) ? 'Simpan Perubahan' : 'Tambah Aplikasi' }}
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
$(document).ready(function () {
    $('select').each(function () {
        $(this).select2({
            dropdownParent: $('body'),
            width: '100%'
        });
    });
});
</script>
@endpush