@extends('layouts.main')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
<style>

    .password-strength-meter {
        margin-top: 8px;
    }
    
    .strength-bar {
        display: flex;
        gap: 5px;
        margin-bottom: 5px;
    }
    
    .strength-segment {
        height: 4px;
        flex: 1;
        background-color: #e0e0e0;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    .strength-segment.active.segment-1 {
        background-color: #dc3545;
    }
    
    .strength-segment.active.segment-2 {
        background-color: #ffc107;
    }
    
    .strength-segment.active.segment-3 {
        background-color: #28a745;
    }
    
    .strength-segment.active.segment-4 {
        background-color: #20c997;
    }
    
    .strength-text {
        font-size: 12px;
        color: #6c757d;
    }
    
    /* Password requirements list */
    .password-requirements {
        list-style: none;
        padding-left: 0;
        margin-top: 8px;
        margin-bottom: 0;
        font-size: 12px;
    }
    
    .password-requirements li {
        margin-bottom: 4px;
        color: #6c757d;
    }
    
    .password-requirements li.valid {
        color: #28a745;
    }
    
    .password-requirements li i {
        margin-right: 6px;
        font-size: 10px;
    }
    
    .password-requirements li.valid i {
        color: #28a745;
    }

</style>
@endpush

@section('content')
<main class="nxl-container">
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
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
                        <a href="{{ route('users.index') }}" class="btn btn-light-brand">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <button type="submit" form="formUser" class="btn btn-primary">
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
                <strong>Terdapat kesalahan pada form:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form id="formUser" action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Informasi User</h5>
                    </div>
                    <div class="card-body">

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   id="password"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            
                            {{-- Password Strength Meter --}}
                            <div class="password-strength-meter">
                                <div class="strength-bar">
                                    <div class="strength-segment" id="segment-1"></div>
                                    <div class="strength-segment" id="segment-2"></div>
                                    <div class="strength-segment" id="segment-3"></div>
                                    <div class="strength-segment" id="segment-4"></div>
                                </div>
                                <div class="strength-text" id="strength-text">Kekuatan password</div>
                            </div>
                            
                            {{-- Password Requirements --}}
                            <ul class="password-requirements">
                                <li id="req-length">
                                    <i class="feather-circle"></i> Minimal 8 karakter
                                </li>
                                <li id="req-uppercase">
                                    <i class="feather-circle"></i> Huruf besar (A-Z)
                                </li>
                                <li id="req-lowercase">
                                    <i class="feather-circle"></i> Huruf kecil (a-z)
                                </li>
                                <li id="req-number">
                                    <i class="feather-circle"></i> Angka (0-9)
                                </li>
                                <li id="req-symbol">
                                    <i class="feather-circle"></i> Simbol (!@#$%^&*)
                                </li>
                            </ul>
                            
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Ketik ulang password"
                                   required>
                            <div class="fs-12 text-muted mt-1" id="password-match"></div>
                            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-14">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                    name="role" id="roleSelect" required>
                                <option value="">— Pilih Role —</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>
                                    {{ ucfirst($role->value) }}
                                </option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-light-brand">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-save me-2"></i>Simpan User
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
    // Initialize Select2
    $('#roleSelect').select2({
        dropdownParent: $('body'),
        width: '100%',
        placeholder: '— Pilih Role —'
    });
    
    // Password strength checker
    function checkPasswordStrength(password) {
        let score = 0;
        
        // Length check
        if (password.length >= 8) score += 1;
        
        // Uppercase check
        if (/[A-Z]/.test(password)) score += 1;
        
        // Lowercase check
        if (/[a-z]/.test(password)) score += 1;
        
        // Number check
        if (/[0-9]/.test(password)) score += 1;
        
        // Symbol check
        if (/[^A-Za-z0-9]/.test(password)) score += 1;
        
        return Math.min(score, 4);
    }
    
    function updatePasswordStrength(password) {
        const score = checkPasswordStrength(password);
        const segments = document.querySelectorAll('.strength-segment');
        const strengthText = document.getElementById('strength-text');
        
        // Reset all segments
        segments.forEach(seg => {
            seg.classList.remove('active', 'segment-1', 'segment-2', 'segment-3', 'segment-4');
        });
        
        if (password.length === 0) {
            strengthText.textContent = 'Kekuatan password';
            return;
        }
        
        // Update segments based on score
        for (let i = 0; i < score; i++) {
            segments[i].classList.add('active', `segment-${Math.min(i+1, 4)}`);
        }
        
        // Update text
        const texts = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
        strengthText.textContent = `Kekuatan password: ${texts[score]}`;
    }
    
    function updateRequirements(password) {
        // Length
        const reqLength = document.getElementById('req-length');
        if (password.length >= 8) {
            reqLength.classList.add('valid');
            reqLength.querySelector('i').className = 'feather-check-circle';
        } else {
            reqLength.classList.remove('valid');
            reqLength.querySelector('i').className = 'feather-circle';
        }
        
        // Uppercase
        const reqUppercase = document.getElementById('req-uppercase');
        if (/[A-Z]/.test(password)) {
            reqUppercase.classList.add('valid');
            reqUppercase.querySelector('i').className = 'feather-check-circle';
        } else {
            reqUppercase.classList.remove('valid');
            reqUppercase.querySelector('i').className = 'feather-circle';
        }
        
        // Lowercase
        const reqLowercase = document.getElementById('req-lowercase');
        if (/[a-z]/.test(password)) {
            reqLowercase.classList.add('valid');
            reqLowercase.querySelector('i').className = 'feather-check-circle';
        } else {
            reqLowercase.classList.remove('valid');
            reqLowercase.querySelector('i').className = 'feather-circle';
        }
        
        // Number
        const reqNumber = document.getElementById('req-number');
        if (/[0-9]/.test(password)) {
            reqNumber.classList.add('valid');
            reqNumber.querySelector('i').className = 'feather-check-circle';
        } else {
            reqNumber.classList.remove('valid');
            reqNumber.querySelector('i').className = 'feather-circle';
        }
        
        // Symbol
        const reqSymbol = document.getElementById('req-symbol');
        if (/[^A-Za-z0-9]/.test(password)) {
            reqSymbol.classList.add('valid');
            reqSymbol.querySelector('i').className = 'feather-check-circle';
        } else {
            reqSymbol.classList.remove('valid');
            reqSymbol.querySelector('i').className = 'feather-circle';
        }
    }
    
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        const matchDiv = document.getElementById('password-match');
        
        if (confirm.length === 0) {
            matchDiv.innerHTML = '';
            matchDiv.className = 'fs-12 text-muted mt-1';
        } else if (password === confirm) {
            matchDiv.innerHTML = '<i class="feather-check-circle text-success me-1"></i> Password cocok';
            matchDiv.className = 'fs-12 text-success mt-1';
        } else {
            matchDiv.innerHTML = '<i class="feather-alert-circle text-danger me-1"></i> Password tidak cocok';
            matchDiv.className = 'fs-12 text-danger mt-1';
        }
    }
    
    // Event listeners
    $('#password').on('input', function() {
        const password = $(this).val();
        updatePasswordStrength(password);
        updateRequirements(password);
        checkPasswordMatch();
    });
    
    $('#password_confirmation').on('input', checkPasswordMatch);
});
</script>
@endpush