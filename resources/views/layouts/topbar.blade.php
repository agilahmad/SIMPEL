<header class="nxl-header">
    <div class="header-wrapper">
        <div class="header-left d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="feather-arrow-right"></i>
                </a>
            </div>
            <div class="nxl-lavel-mega-menu-toggle d-flex d-lg-none">
                <a href="javascript:void(0);" id="nxl-lavel-mega-menu-open">
                    <i class="feather-align-left"></i>
                </a>
            </div>
        </div>

        <div class="header-right ms-auto">
            <div class="d-flex align-items-center">

                <div class="nxl-h-item d-none d-sm-flex">
                    <div class="full-screen-switcher">
                        <a href="javascript:void(0);" class="nxl-head-link me-0"
                            onclick="$('body').fullScreenHelper('toggle');">
                            <i class="feather-maximize maximize"></i>
                            <i class="feather-minimize minimize"></i>
                        </a>
                    </div>
                </div>

                <div class="nxl-h-item dark-light-theme">
                    <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                        <i class="feather-moon"></i>
                    </a>
                    <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none">
                        <i class="feather-sun"></i>
                    </a>
                </div>

                {{-- NOTIFIKASI --}}
                <div class="dropdown nxl-h-item">
                    <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button"
                        data-bs-auto-close="outside">
                        <i class="feather-bell"></i>
                        <span class="badge bg-danger nxl-h-badge d-none" id="notif-badge"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu">
                        <div class="d-flex justify-content-between align-items-center notifications-head">
                            <h6 class="fw-bold text-dark mb-0">Notifikasi</h6>
                            <a href="javascript:void(0);" class="fs-11 text-success text-end ms-auto d-none"
                                id="mark-all-read-btn" data-url="{{ route('notifications.readAll') }}">
                                <i class="feather-check"></i>
                                <span>Tandai Semua Dibaca</span>
                            </a>
                        </div>

                        <div id="notif-list">
                            <div class="text-center py-4 text-muted fs-13">
                                <i class="feather-loader d-block fs-24 mb-2"></i>
                                Memuat...
                            </div>
                        </div>

                        <div class="text-center notifications-footer">
                            <a href="{{ route('notifications.index') }}" class="fs-13 fw-semibold text-dark">
                                Semua Notifikasi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        <div
                            class="avatar-text avatar-md bg-soft-primary text-primary rounded-circle fw-bold fs-14 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name, ' '), 1, 1)) }}
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown"
                        style="min-width: 200px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); border: 1px solid rgba(0,0,0,0.07); padding: 6px; margin-top: 8px;">
                        <div class="px-3 py-2 mb-1">
                            <div class="fw-semibold fs-14 text-dark">{{ auth()->user()->name }}</div>
                            <div class="fs-12 text-muted">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="dropdown-divider my-1"></div>
                        <a href="{{ route('profile.edit') }}"
                            class="dropdown-item rounded-2 d-flex align-items-center gap-2" style="padding: 8px 12px;">
                            <i class="feather-user fs-15"></i>
                            <span>Profile</span>
                        </a>
                        <div class="dropdown-divider my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                class="dropdown-item rounded-2 d-flex align-items-center gap-2 w-100 border-0 bg-transparent text-danger"
                                style="padding: 8px 12px;">
                                <i class="feather-log-out fs-15"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<script>
(function () {
    const CSRF        = '{{ csrf_token() }}';
    const POLL_URL    = '{{ route("notifications.poll") }}';
    const INTERVAL_MS = 30000;

    const icons = {
        community_report_new:          { icon: 'feather-alert-circle',  color: 'text-danger'   },
        incident_new_programmer:        { icon: 'feather-activity',       color: 'text-primary'  },
        community_report_done:          { icon: 'feather-check-circle',   color: 'text-success'  },
        incident_rejected_programmer:   { icon: 'feather-x-circle',       color: 'text-danger'   },
        incident_in_progress_admin:     { icon: 'feather-clock',          color: 'text-warning'  },
    };

    function resolveHref(n) {
        if (n.url) return n.url;
        return 'javascript:void(0);';
    }

    function renderNotifications(data) {
        const badge      = document.getElementById('notif-badge');
        const markAllBtn = document.getElementById('mark-all-read-btn');
        const list       = document.getElementById('notif-list');

        if (data.unread_count > 0) {
            badge.textContent = data.unread_count;
            badge.classList.remove('d-none');
            markAllBtn.classList.remove('d-none');
        } else {
            badge.classList.add('d-none');
            markAllBtn.classList.add('d-none');
        }

        if (data.notifications.length === 0) {
            list.innerHTML = `
                <div class="text-center py-4 text-muted fs-13">
                    <i class="feather-bell-off d-block fs-24 mb-2"></i>
                    Tidak ada notifikasi
                </div>`;
            return;
        }

        list.innerHTML = data.notifications.map(function (n) {
            const ic           = icons[n.type] ?? { icon: 'feather-bell', color: 'text-secondary' };
            const href         = resolveHref(n);
            const opacityClass = n.is_read ? 'opacity-75' : '';
            const dotBtn       = !n.is_read
                ? `<a href="javascript:void(0);"
                       class="d-block wd-8 ht-8 rounded-circle bg-primary mark-read-btn"
                       data-id="${n.id}"
                       data-url="/notifications/${n.id}/read"
                       data-bs-toggle="tooltip"
                       title="Tandai Dibaca"></a>`
                : '';

            return `
            <div class="notifications-item ${opacityClass}" id="notif-${n.id}">
                <div class="rounded me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:40px;height:40px;background:transparent;">
                    <i class="${ic.icon} ${ic.color} fs-20"></i>
                </div>
                <div class="notifications-desc">
                    <a href="${href}" class="font-body text-truncate-2-line">
                        <span class="fw-semibold text-dark">${n.title}</span>
                        ${n.message}
                    </a>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="notifications-date text-muted border-bottom border-bottom-dashed">
                            ${n.created_at}
                        </div>
                        <div class="d-flex align-items-center float-end gap-2">
                            ${dotBtn}
                        </div>
                    </div>
                </div>
            </div>`;
        }).join('');

        attachMarkRead();
    }

    function fetchNotifications() {
        fetch(POLL_URL, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        })
        .then(r => r.json())
        .then(renderNotifications)
        .catch(() => {});
    }

    function attachMarkRead() {
        document.querySelectorAll('.mark-read-btn').forEach(function (btn) {
            if (btn.dataset.bound) return;
            btn.dataset.bound = '1';

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                fetch(this.dataset.url, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                }).then(() => fetchNotifications());
            });
        });
    }

    const markAllBtn = document.getElementById('mark-all-read-btn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function () {
            fetch(this.dataset.url, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            }).then(() => fetchNotifications());
        });
    }

    fetchNotifications();
    setInterval(fetchNotifications, INTERVAL_MS);

    const dropdownToggle = document.querySelector('[data-bs-toggle="dropdown"] .feather-bell')
        ?.closest('a');
    if (dropdownToggle) {
        dropdownToggle.addEventListener('click', fetchNotifications);
    }
})();
</script>