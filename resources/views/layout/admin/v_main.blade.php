<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.admin.v_head')

</head>

<body class="sidebar-noneoverflow">

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    @php
                        $setting = json_decode(file_get_contents(storage_path('app/settings.json')), true);
                    @endphp
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ isset($setting['logo']) ? asset($setting['logo']) : asset('asset/img/90x90.jpg') }}"
                            class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        {{ isset($setting['name_school']) ? $setting['name_school'] : 'E-Raport' }} </a>
                </li>
                <li class="nav-item toggle-sidebar">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-list">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3" y2="6"></line>
                            <line x1="3" y1="12" x2="3" y2="12"></line>
                            <line x1="3" y1="18" x2="3" y2="18"></line>
                        </svg></a>
                </li>
            </ul>

            <ul class="navbar-item flex-row navbar-dropdown ml-auto">

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-settings">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp"
                        aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                @php
                                    $user = Auth::user();
                                    $name = $user->name;
                                    $file = $user->file;
                                    $role = session('role');
                                @endphp
                                <img src="{{ $file ? asset($file) : asset('asset/img/90x90.jpg') }}"
                                    class="img-fluid mr-2" alt="avatar">
                                {{-- <img src="{{ asset('asset/img/90x90.jpg') }}" class="img-fluid mr-2" alt="avatar"> --}}
                                <div class="media-body">
                                    <h5 class="text-capitalize">{{ $name }}</h5>
                                    <p class="text-capitalize">{{ $role }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('profiles.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>My Profile</span>
                            </a>
                        </div>
                        @if (session('role') == 'teacher' && session('type-teacher') == 'homeroom')
                            @if (session('layout') == 'teacher')
                                <div class="dropdown-item">
                                    <a href="{{ route('session.layout', ['layout' => 'homeroom']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3" />
                                            <circle cx="12" cy="10" r="3" />
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        <span>Wali Kelas</span>
                                    </a>
                                </div>
                            @else
                                <div class="dropdown-item">
                                    <a href="{{ route('session.layout', ['layout' => 'teacher']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        <span>Guru Pelajaran</span>
                                    </a>
                                </div>
                            @endif
                        @endif
                        <div class="dropdown-item">
                            <a href="{{ route('auth.logout') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @php
            $guard = Auth::getDefaultDriver();
        @endphp
        @switch($guard)
            @case('admin')
                @include('layout.admin.v_sidebar_admin')
            @break

            @case('user')
            @case('parent')
                @include('layout.admin.v_sidebar_user')
            @break

            @case('teacher')
                @if (session('layout') == 'teacher')
                    @include('layout.admin.v_sidebar_teacher')
                @else
                    @include('layout.admin.v_sidebar_homeroom')
                @endif
            @break

            @default
        @endswitch
        <div id="content" class="main-content">
            @yield('content')
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">
                        {{ isset($setting['footer']) ? $setting['footer'] : 'Copyright © 2023 Design by, MYSCH.ID' }}.
                    </p>
                </div>

            </div>
        </div>
    </div>
    @stack('modals')
    @include('layout.admin.v_foot')
</body>

</html>
