<div id="layoutSidenav_nav">

    <div class="user_profile">
        <img class="profile-image"
            src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/img/no-img.jpg') }}"
            alt="">

        <div class="profile-title text-capitalize">{{ Auth::user()->name }}</div>
        <div class="profile-description">{{ Auth::user()->roles->name }}</div>
    </div>

    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- admin  --}}
                @if (Helper::hasRight('dashboard.view'))
                    <a class="nav-link {{ Route::is('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}"
                        href="{{ route('admin.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>
                @endif
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#messageNav"
                    aria-expanded="@if (Route::is('admin.message') || Route::is('admin.message')) true @else false @endif"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-video"></i></div> Messages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if (Route::is('admin.message') || Route::is('admin.message.requests.index')) show @endif" id="messageNav"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav down">
                        <a class="nav-link {{ Route::is('admin.message') ? 'active' : '' }}"
                            href="{{ route('admin.message') }}"><i class="fa-solid fa-angles-right ikon"></i>
                            All Messages</a>
                        <a class="nav-link {{ Route::is('admin.message.requests.index') ? 'active' : '' }}"
                            href="{{ route('admin.message.requests.index') }}"><i
                                class="fa-solid fa-angles-right ikon"></i>
                            Message Requests</a>
                    </nav>
                </div>
                {{-- Video started --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#videoNav"
                    aria-expanded="@if (Route::is('admin.regular.video.free') ||
                            Route::is('admin.amol.video.free') ||
                            Route::is('admin.video.premium') ||
                            Route::is('admin.amol.video.premium')) true @else false @endif"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-video"></i></div> Videos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if (Route::is('admin.regular.video.free') ||
                        Route::is('admin.amol.video.free') ||
                        Route::is('admin.video.premium') ||
                        Route::is('admin.amol.video.premium')) show @endif" id="videoNav"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav down">
                        <a class="nav-link {{ Route::is('admin.regular.video.free') ? 'active' : '' }}"
                            href="{{ route('admin.regular.video.free') }}"><i
                                class="fa-solid fa-angles-right ikon"></i>
                            নিয়মিত ভিডিও FREE </a>
                        <a class="nav-link {{ Route::is('admin.amol.video.free') ? 'active' : '' }}"
                            href="{{ route('admin.amol.video.free') }}"><i class="fa-solid fa-angles-right ikon"></i>
                            আমল ভিডিও FREE </a>
                        <a class="nav-link {{ Route::is('admin.amol.video.premium') ? 'active' : '' }}"
                            href="{{ route('admin.amol.video.premium') }}"><i
                                class="fa-solid fa-angles-right ikon"></i>
                            প্রিমিয়াম আমল ভিডিও </a>
                        <a class="nav-link {{ Route::is('admin.video.premium') ? 'active' : '' }}"
                            href="{{ route('admin.video.premium') }}"><i class="fa-solid fa-angles-right ikon"></i>
                            প্রিমিয়াম ভিডিও </a>
                    </nav>
                </div>
                {{-- Video ended --}}
                <a class="nav-link {{ Route::is('admin.custom.ads') ? 'active' : '' }}"
                    href="{{ route('admin.custom.ads') }}" href="{{ route('admin.custom.ads') }}">
                    <div class="sb-nav-link-icon"><i class="fa-brands fa-adversal"></i></div> Custom Ads
                </a>
                {{-- @if (Helper::hasRight('setting.view'))
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setupNav"
                        aria-expanded="@if (Route::is('admin.role') || Route::is('admin.role.create') || Route::is('admin.role.edit') || Route::is('admin.role.right') || Route::is('admin.user.details') || Route::is('admin.driver') || Route::is('admin.driver.details') || Route::is('admin.dispatcher') || Route::is('admin.dispatcher.details') || Route::is('admin.user')) true @else false @endif"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div> Administration
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @if (Route::is('admin.role') || Route::is('admin.role.create') || Route::is('admin.role.edit') || Route::is('admin.role.right') || Route::is('admin.user.details') || Route::is('admin.driver') || Route::is('admin.driver.details') || Route::is('admin.dispatcher') || Route::is('admin.dispatcher.details') || Route::is('admin.user')) show @endif" id="setupNav"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav down">
                            @if (Helper::hasRight('role.view'))
                                <a class="nav-link {{ Route::is('admin.role') || Route::is('admin.role.create') || Route::is('admin.role.edit') ? 'active' : '' }}"
                                    href="{{ route('admin.role') }}"><i class="fa-solid fa-angles-right ikon"></i> Role
                                    Management</a>
                            @endif
                            @if (Helper::hasRight('right.view'))
                                <a class="nav-link {{ Route::is('admin.role.right') ? 'active' : '' }}"
                                    href="{{ route('admin.role.right') }}"><i class="fa-solid fa-angles-right ikon"></i>
                                    Right Management</a>
                            @endif
                            @if (Helper::hasRight('user.view'))
                                <a class="nav-link {{ Route::is('admin.user') || Route::is('admin.user.details') ? 'active' : '' }}"
                                    href="{{ route('admin.user') }}"><i class="fa-solid fa-angles-right ikon"></i> User
                                    Management
                                </a>
                            @endif
                        </nav>
                    </div>
                @endif --}}
                @if (Helper::hasRight('setting.view'))
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#settingNav"
                        aria-expanded="@if (Route::is('admin.setting.general') ||
                                Route::is('admin.setting.static.content') ||
                                Route::is('admin.setting.legal.content') ||
                                Route::is('admin.contact') ||
                                Route::is('admin.resource')) true @else false @endif"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div> Settings
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @if (Route::is('admin.setting.general') ||
                            Route::is('admin.setting.static.content') ||
                            Route::is('admin.setting.legal.content') ||
                            Route::is('admin.contact') ||
                            Route::is('admin.resource')) show @endif" id="settingNav"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav down">
                            @if (Helper::hasRight('setting.general'))
                                <a class="nav-link {{ Route::is('admin.setting.general') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.general') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> General Setting </a>
                            @endif

                            {{-- @if (Helper::hasRight('setting.static-content'))
                                <a class="nav-link {{ Route::is('admin.setting.static.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.static.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Static Content</a>
                            @endif

                            @if (Helper::hasRight('setting.legal-content'))
                                <a class="nav-link {{ Route::is('admin.setting.legal.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.legal.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Legal Content</a>
                            @endif --}}
                        </nav>
                    </div>
                @endif
                {{-- User started --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#userNav"
                    aria-expanded="@if (Route::is('admin.all.user') || Route::is('admin.paid.user')) true @else false @endif"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-user"></i></div> Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if (Route::is('admin.all.user') || Route::is('admin.paid.user')) show @endif" id="userNav"
                    aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav down">
                        <a class="nav-link {{ Route::is('admin.all.user') ? 'active' : '' }}"
                            href="{{ route('admin.all.user') }}"><i class="fa-solid fa-angles-right ikon"></i>
                            All User </a>
                        {{-- <a class="nav-link {{ Route::is('admin.paid.user') ? 'active' : '' }}"
                            href="{{ route('admin.paid.user') }}"><i class="fa-solid fa-angles-right ikon"></i>
                            Paid User </a> --}}
                    </nav>
                </div>
                {{-- User ended --}}
                <a class="nav-link {{ Route::is('admin.live.channel') ? 'active' : '' }}"
                    href="{{ route('admin.live.channel') }}" href="{{ route('admin.live.channel') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tv"></i></div> Live Channel
                </a>
                <a class="nav-link {{ Route::is('admin.tafsir') ? 'active' : '' }}"
                    href="{{ route('admin.tafsir') }}" href="{{ route('admin.tafsir') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-book-quran"></i></div> তাসফীর
                </a>
                <a class="nav-link {{ Route::is('admin.transaction.history') ? 'active' : '' }}"
                    href="{{ route('admin.transaction.history') }}" href="{{ route('admin.transaction.history') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-book-quran"></i></div> Transaction History
                </a>
            </div>
        </div>
    </nav>
</div>
