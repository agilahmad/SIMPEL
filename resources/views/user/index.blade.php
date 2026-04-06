@extends('layouts.main')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Manajemen User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">User</li>
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
                        <a href="javascript:void(0);" class="btn btn-icon btn-light-brand" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            <i class="feather-bar-chart"></i>
                        </a>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Tambah User</span>
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

        <div id="collapseOne" class="accordion-collapse collapse page-header-collapse">
            <div class="accordion-body pb-2">
                <div class="row">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">Total User</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $users->total() }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                            <span>Semua User</span>
                                            <i class="feather-link-2 fs-10 ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">Admin</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $admin_count ?? 0 }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                            <span>Role Admin</span>
                                            <i class="feather-link-2 fs-10 ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ $users->total() > 0 ? (($admin_count ?? 0) / $users->total()) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">Programmer</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $programmer_count ?? 0 }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                            <span>Role Programmer</span>
                                            <i class="feather-link-2 fs-10 ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{ $users->total() > 0 ? (($programmer_count ?? 0) / $users->total()) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">User</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $user_count ?? 0 }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted">
                                            <span>Role User</span>
                                            <i class="feather-link-2 fs-10 ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $users->total() > 0 ? (($user_count ?? 0) / $users->total()) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="feather-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="userList">
                                    <thead>
                                        <tr>
                                            <th class="wd-30">#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Dibuat</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                        <tr class="single-item">
                                            <td>
                                                <span class="fs-12 fw-semibold text-muted">
                                                    {{ $users->firstItem() + $loop->index }}
                                                </span>
                                            </td>
                                            <td class="project-name-td">
                                                <div class="hstack gap-4">
                                                    <div class="avatar-image border-0">
                                                        <span class="avatar-text avatar-md bg-soft-primary text-primary rounded">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0);" class="text-truncate-1-line fw-semibold">
                                                            {{ $user->name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fs-12 text-muted">{{ $user->email }}</span>
                                            </td>
                                            <td>
                                                @if($user->role->value == 'admin')
                                                <span class="badge bg-soft-danger text-danger">Admin</span>
                                                @elseif($user->role->value == 'programmer')
                                                <span class="badge bg-soft-warning text-warning">Programmer</span>
                                                @else
                                                <span class="badge bg-soft-success text-success">User</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fs-12 text-muted">{{ $user->created_at->format('d M Y') }}</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="nxl-dropdown-action" data-nxl-dropdown>
                                                    <button type="button" class="avatar-text avatar-md nxl-dropdown-toggle" aria-label="Aksi">
                                                        <i class="feather feather-more-horizontal"></i>
                                                    </button>
                                                    <ul class="nxl-dropdown-menu dropdown-menu shadow-lg">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('users.edit', $user) }}">
                                                                <i class="feather feather-edit-3 me-3"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                                onsubmit="return confirm('Hapus user ini?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                                                    <i class="feather feather-trash-2 me-3"></i>
                                                                    <span>Hapus</span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <i class="feather-inbox fs-1 d-block mb-2"></i>
                                                Belum ada data user
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($users->hasPages())
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <p class="fs-12 text-muted mb-0">
                                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} data
                            </p>
                            {{ $users->links() }}
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

@push('js')
@include('partials.nxl-dropdown-js')
@endpush