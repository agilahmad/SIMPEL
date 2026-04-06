@extends('layouts.main')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Notifikasi</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Notifikasi</li>
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
                            @if ($stats['unread'] > 0)
                                <button class="btn btn-primary" id="markAllBtn"
                                    data-url="{{ route('notifications.readAll') }}">
                                    <i class="feather-check-circle me-2"></i>
                                    <span>Tandai Semua Dibaca</span>
                                </button>
                            @endif
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

                <div class="row mb-3">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">Total Notifikasi</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $stats['total'] }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted"><span>Semua Notifikasi</span></a>
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
                                    <span class="d-block">Belum Dibaca</span>
                                    <span class="fs-24 fw-bolder d-block" id="stat-unread">{{ $stats['unread'] }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted"><span>Perlu Diperhatikan</span></a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['unread'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">Sudah Dibaca</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $stats['read'] }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted"><span>Telah Ditindaklanjuti</span></a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['read'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="fw-bold d-block">
                                    <span class="d-block">Laporan Masyarakat</span>
                                    <span class="fs-24 fw-bolder d-block">{{ $stats['community_new'] }}</span>
                                </a>
                                <div class="pt-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0);" class="fs-12 fw-medium text-muted"><span>Dari Masyarakat</span></a>
                                    </div>
                                    <div class="progress mt-2 ht-3">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['community_new'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button class="btn btn-sm filter-btn btn-primary active" data-filter="all">Semua</button>
                                    <button class="btn btn-sm filter-btn btn-light-brand" data-filter="unread">Belum Dibaca</button>
                                    <button class="btn btn-sm filter-btn btn-light-brand" data-filter="community_report_new">Lap. Masyarakat</button>
                                    <button class="btn btn-sm filter-btn btn-light-brand" data-filter="incident_new_programmer">Potensi Insiden</button>
                                    <button class="btn btn-sm filter-btn btn-light-brand" data-filter="incident_in_progress_admin">Dalam Proses</button>
                                    <button class="btn btn-sm filter-btn btn-light-brand" data-filter="community_report_done">Selesai</button>
                                </div>
                                <span class="fs-12 text-muted">
                                    Menampilkan <span id="visible-count">{{ $stats['total'] }}</span> notifikasi
                                </span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="notifTable">
                                        <thead>
                                            <tr>
                                                <th class="wd-30">#</th>
                                                <th>Notifikasi</th>
                                                <th>Tipe</th>
                                                <th>Waktu</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="notifList">
                                            @php
                                                $typeConfig = [
                                                    'community_report_new' => [
                                                        'label' => 'Lap. Masyarakat',
                                                        'badge' => 'bg-soft-danger text-danger',
                                                        'icon'  => 'feather-alert-circle',
                                                        'color' => '#dc3545',
                                                    ],
                                                    'incident_new_programmer' => [
                                                        'label' => 'Incident Baru',
                                                        'badge' => 'bg-soft-primary text-primary',
                                                        'icon'  => 'feather-activity',
                                                        'color' => '#2563EB',
                                                    ],
                                                    'community_report_done' => [
                                                        'label' => 'Selesai',
                                                        'badge' => 'bg-soft-success text-success',
                                                        'icon'  => 'feather-check-circle',
                                                        'color' => '#16a34a',
                                                    ],
                                                    'incident_rejected_programmer' => [
                                                        'label' => 'Ditolak',
                                                        'badge' => 'bg-soft-danger text-danger',
                                                        'icon'  => 'feather-x-circle',
                                                        'color' => '#dc3545',
                                                    ],
                                                    'incident_in_progress_admin' => [
                                                        'label' => 'Dalam Proses',
                                                        'badge' => 'bg-soft-warning text-warning',
                                                        'icon'  => 'feather-clock',
                                                        'color' => '#d97706',
                                                    ],
                                                ];
                                            @endphp

                                            @forelse($notifications as $i => $notif)
                                                @php
                                                    $cfg = $typeConfig[$notif->type] ?? [
                                                        'label' => $notif->type,
                                                        'badge' => 'bg-soft-secondary text-secondary',
                                                        'icon'  => 'feather-bell',
                                                        'color' => '#6c757d',
                                                    ];

                                                    if ($notif->incident_id) {
                                                        $rowUrl = route('incidents.show', $notif->incident_id);
                                                    } elseif ($notif->pentest_id) {
                                                        $rowUrl = route('pentests.show', $notif->pentest_id);
                                                    } else {
                                                        $rowUrl = '#';
                                                    }
                                                @endphp
                                                <tr class="single-item notif-row {{ $notif->is_read ? '' : 'table-active' }}"
                                                    id="notif-row-{{ $notif->id }}"
                                                    data-type="{{ $notif->type }}"
                                                    data-read="{{ $notif->is_read ? '1' : '0' }}"
                                                    data-url="{{ $rowUrl }}"
                                                    style="cursor: pointer;">
                                                    <td>
                                                        <span class="fs-12 fw-semibold text-muted ms-1">{{ $notifications->firstItem() + $loop->index }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <div class="flex-shrink-0">
                                                                <span class="avatar-text avatar-md rounded d-flex align-items-center justify-content-center"
                                                                    style="background-color: {{ $cfg['color'] }}1a; color: {{ $cfg['color'] }}; width:40px; height:40px;">
                                                                    <i class="{{ $cfg['icon'] }}" style="font-size: 18px;"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="fw-semibold d-block {{ $notif->is_read ? 'text-muted' : 'text-dark' }}"
                                                                    style="max-width: 380px;">
                                                                    {{ $notif->title }}
                                                                </span>
                                                                <span class="fs-12 text-muted d-block text-truncate-1-line"
                                                                    style="max-width: 380px;">
                                                                    {{ $notif->message }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $cfg['badge'] }} fs-12">{{ $cfg['label'] }}</span>
                                                    </td>
                                                    <td class="fs-12 text-muted">
                                                        {{ $notif->created_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        @if ($notif->is_read)
                                                            <span class="badge bg-soft-success text-success fs-12">Dibaca</span>
                                                        @else
                                                            <span class="badge bg-soft-warning text-warning fs-12 notif-status-badge">Belum Dibaca</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr id="emptyRow">
                                                    <td colspan="5" class="text-center text-muted py-5">
                                                        <i class="feather-bell-off fs-1 d-block mb-2"></i>
                                                        Belum ada notifikasi
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($notifications->hasPages())
                                <div class="card-footer d-flex justify-content-end">
                                    {{ $notifications->links() }}
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
    <script>
        (function () {
            const csrf = '{{ csrf_token() }}';

            function resolveUrl(row) {
                const url = row.dataset.url;
                return url && url !== '#' ? url : null;
            }

            document.querySelectorAll('.notif-row').forEach(function (row) {
                row.addEventListener('click', function () {
                    const id     = this.id.replace('notif-row-', '');
                    const isRead = this.dataset.read === '1';
                    const url    = resolveUrl(this);

                    if (!isRead) {
                        fetch('{{ url('notifications') }}/' + id + '/read', {
                            method: 'PATCH',
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                        }).then(res => {
                            if (!res.ok) throw new Error('Request gagal');
                            return res.json();
                        }).then(data => {
                            markRowAsRead(row);
                            const target = data.redirect_url || url;
                            if (target) window.location.href = target;
                        }).catch(() => {
                            if (url) window.location.href = url;
                        });
                    } else {
                        if (url) window.location.href = url;
                    }
                });
            });

            function markRowAsRead(row) {
                row.classList.remove('table-active');
                row.dataset.read = '1';

                const titleEl = row.querySelector('.fw-semibold');
                if (titleEl) {
                    titleEl.classList.remove('text-dark');
                    titleEl.classList.add('text-muted');
                }

                const statusBadge = row.querySelector('.notif-status-badge');
                if (statusBadge) {
                    statusBadge.className = 'badge bg-soft-success text-success fs-12';
                    statusBadge.textContent = 'Dibaca';
                }

                updateUnread(-1);
            }

            const markAllBtn = document.getElementById('markAllBtn');
            if (markAllBtn) {
                markAllBtn.addEventListener('click', function () {
                    fetch(this.dataset.url, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                }).then(res => {
                    if (!res.ok) throw new Error('Gagal');
                    document.querySelectorAll('.notif-row').forEach(markRowAsRead);
                    markAllBtn.style.display = 'none';
                }).catch(() => alert('Gagal menandai semua notifikasi.'));
                });
            }

            document.querySelectorAll('.filter-btn').forEach(function (tab) {
                tab.addEventListener('click', function () {
                    document.querySelectorAll('.filter-btn').forEach(function (t) {
                        t.classList.remove('btn-primary', 'active');
                        t.classList.add('btn-light-brand');
                    });
                    this.classList.add('btn-primary', 'active');
                    this.classList.remove('btn-light-brand');

                    const filter = this.dataset.filter;
                    let visible = 0;
                    document.querySelectorAll('.notif-row').forEach(function (row) {
                        const show = filter === 'all' ||
                            (filter === 'unread' && row.dataset.read === '0') ||
                            row.dataset.type === filter;
                        row.style.display = show ? '' : 'none';
                        if (show) visible++;
                    });
                    document.getElementById('visible-count').textContent = visible;
                });
            });

            function updateUnread(delta) {
                const el  = document.getElementById('stat-unread');
                const val = Math.max(0, parseInt(el.textContent) + delta);
                el.textContent = val;
            }
        })();
    </script>
@endpush