<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <a href="{{ route('dashboard') }}" class="logo logo-lg text-decoration-none">
                    <span
                        style="
                            font-family: 'Poppins', sans-serif;
                            font-weight: 700;
                            font-size: 26px;
                            letter-spacing: 1px;
                            background: linear-gradient(90deg, #4f46e5, #06b6d4);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            display: inline-block;
                        ">
                        Dashboard
                </a>
                <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="" class="logo logo-sm">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigasi</label>
                </li>

                <li class="nxl-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->isAdmin() || auth()->user()->isProgrammer())
                    <li class="nxl-item nxl-caption">
                        <label>Manajemen</label>
                    </li>
                @endif

                @if (auth()->user()->isAdmin())
                    <li class="nxl-item {{ request()->routeIs('applications.*') ? 'active' : '' }}">
                        <a href="{{ route('applications.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-grid"></i></span>
                            <span class="nxl-mtext">Aplikasi</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu {{ request()->routeIs('vas.*') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-alert-circle"></i></span>
                            <span class="nxl-mtext">Vulnerability Assessment</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item {{ request()->routeIs('vas.index') ? 'active' : '' }}">
                                <a class="nxl-link" href="{{ route('vas.index') }}">Daftar VA</a>
                            </li>
                            <li class="nxl-item {{ request()->routeIs('vas.create') ? 'active' : '' }}">
                                <a class="nxl-link" href="{{ route('vas.create') }}"> Tambah VA</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->isAdmin() || auth()->user()->isProgrammer())
                    <li class="nxl-item nxl-hasmenu {{ request()->routeIs('pentests.*') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-shield"></i></span>
                            <span class="nxl-mtext">
                                Pentest
                            </span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>

                        <ul class="nxl-submenu">

                            <li class="nxl-item {{ request()->routeIs('pentests.index') ? 'active' : '' }}">
                                <a class="nxl-link" href="{{ route('pentests.index') }}">
                                    {{ auth()->user()->isProgrammer() ? 'Perbaikan' : 'Daftar Pentest' }}
                                </a>
                            </li>

                            @if (auth()->user()->isAdmin())
                                <li class="nxl-item {{ request()->routeIs('pentests.create') ? 'active' : '' }}">
                                    <a class="nxl-link" href="{{ route('pentests.create') }}">
                                        Tambah Pentest
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                <li class="nxl-item nxl-caption">
                    <label>Insiden</label>
                </li>

                @if (auth()->user()->isProgrammer())
                    <li
                        class="nxl-item {{ request()->routeIs('incidents.index') && !request()->get('type') ? 'active' : '' }}">
                        <a href="{{ route('incidents.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-alert-circle"></i></span>
                            <span class="nxl-mtext">Assigned to Me</span>
                        </a>
                    </li>
                @elseif(auth()->user()->isUser())
                    <li class="nxl-item nxl-hasmenu {{ request()->routeIs('incidents.*') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-alert-circle"></i></span>
                            <span class="nxl-mtext">Insiden Saya</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item {{ request()->routeIs('incidents.index') ? 'active' : '' }}">
                                <a class="nxl-link" href="{{ route('incidents.index') }}">Daftar Insiden</a>
                            </li>
                            <li class="nxl-item {{ request()->routeIs('incidents.create') ? 'active' : '' }}">
                                <a class="nxl-link" href="{{ route('incidents.create') }}">Buat Laporan</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li
                        class="nxl-item nxl-hasmenu {{ request()->routeIs('incidents.*') && request()->get('type') === 'potential_incident' ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-alert-triangle"></i></span>
                            <span class="nxl-mtext">Potensi Insiden</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item">
                                <a class="nxl-link"
                                    href="{{ route('incidents.index', ['type' => 'potential_incident']) }}">Daftar</a>
                            </li>
                            <li class="nxl-item">
                                <a class="nxl-link"
                                    href="{{ route('incidents.create', ['type' => 'potential_incident']) }}">Tambah</a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nxl-item nxl-hasmenu {{ request()->routeIs('incidents.*') && request()->get('type') === 'community_report' ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">Laporan Masyarakat</span>
                            <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                        </a>
                        <ul class="nxl-submenu">
                            <li class="nxl-item">
                                <a class="nxl-link"
                                    href="{{ route('incidents.index', ['type' => 'community_report']) }}">Daftar</a>
                            </li>
                            <li class="nxl-item">
                                <a class="nxl-link"
                                    href="{{ route('incidents.create', ['type' => 'community_report']) }}">Tambah</a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nxl-item {{ request()->routeIs('incidents.index') && !request()->get('type') ? 'active' : '' }}">
                        <a href="{{ route('incidents.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-list"></i></span>
                            <span class="nxl-mtext">Semua Insiden</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isAdmin())
                    <li class="nxl-item nxl-caption">
                        <label>Kelola</label>
                    </li>
                    <li
                        class="nxl-item {{ request()->routeIs('users.index') && !request()->get('type') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">Users Management</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
