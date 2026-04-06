@extends('layouts.main')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Profile</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Profile</li>
                    </ul>
                </div>
            </div>

            <div class="main-content">
                <div class="row g-4">

                    {{-- Kolom Kiri: Identity Card --}}
                    <div class="col-lg-4">
                        <div class="card stretch stretch-full text-center">
                            <div class="card-body py-5">
                                <div class="mx-auto mb-4 rounded-circle bg-soft-primary text-primary fw-bold d-flex align-items-center justify-content-center"
                                    style="width:88px;height:88px;font-size:32px;border:3px solid #d0e8ff;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strstr($user->name . ' ', ' '), 1, 1)) }}
                                </div>
                                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                <p class="text-muted fs-13 mb-2">{{ $user->email }}</p>
                                <span class="badge bg-soft-info text-info px-3 py-2 fs-12">
                                    <i class="feather-shield me-1"></i>{{ ucfirst($user->role->value) }}
                                </span>

                                <hr class="my-4">

                                <div class="text-start">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-text avatar-sm bg-soft-primary text-primary rounded">
                                            <i class="feather-user fs-14"></i>
                                        </div>
                                        <div>
                                            <p class="fs-11 text-muted mb-0">Name</p>
                                            <p class="fs-13 fw-semibold mb-0">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-text avatar-sm bg-soft-success text-success rounded">
                                            <i class="feather-mail fs-14"></i>
                                        </div>
                                        <div>
                                            <p class="fs-11 text-muted mb-0">Email</p>
                                            <p class="fs-13 fw-semibold mb-0">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-text avatar-sm bg-soft-warning text-warning rounded">
                                            <i class="feather-calendar fs-14"></i>
                                        </div>
                                        <div>
                                            <p class="fs-11 text-muted mb-0">Bergabung</p>
                                            <p class="fs-13 fw-semibold mb-0">{{ $user->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form --}}
                    <div class="col-lg-8 d-flex flex-column gap-4">

                        {{-- Form Informasi Akun --}}
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="feather-edit-2 me-2 text-primary"></i>Informasi Akun
                                </h5>
                            </div>
                            <div class="card-body">

                                @if(session('success_name'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
                                        <i class="feather-check-circle fs-16"></i>
                                        <span>{{ session('success_name') }}</span>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if($errors->hasAny(['name','email']))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->only(['name','email']) as $err)
                                                <li class="fs-13">{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ route('profile.update.name') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label fs-12 fw-semibold">Nama Lengkap</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="feather-user fs-14"></i></span>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $user->name) }}"
                                                    placeholder="Nama lengkap">
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                       
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="feather-mail fs-14"></i></span>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $user->email) }}"
                                                    placeholder="Alamat email">
                                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="feather-save me-2"></i>Simpan Perubahan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Form Ubah Password --}}
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="feather-lock me-2 text-warning"></i>Ubah Password
                                </h5>
                            </div>
                            <div class="card-body">

                                @if(session('success_password'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
                                        <i class="feather-check-circle fs-16"></i>
                                        <span>{{ session('success_password') }}</span>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if($errors->hasAny(['current_password','password']))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->only(['current_password','password']) as $err)
                                                <li class="fs-13">{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ route('profile.update.password') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fs-12 fw-semibold">Password Saat Ini</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="feather-lock fs-14"></i></span>
                                                <input type="password" name="current_password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    placeholder="Masukkan password saat ini">
                                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold">Password Baru</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="feather-key fs-14"></i></span>
                                                <input type="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Password baru">
                                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fs-12 fw-semibold">Konfirmasi Password Baru</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="feather-check fs-14"></i></span>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control"
                                                    placeholder="Ulangi password baru">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-warning px-4">
                                                <i class="feather-lock me-2"></i>Ubah Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </main>
@endsection