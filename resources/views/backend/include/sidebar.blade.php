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

                {{-- @if (Helper::hasRight('setting.view'))
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setupNav"
                        aria-expanded="@if (Route::is('admin.role') ||
                                Route::is('admin.role.create') ||
                                Route::is('admin.role.edit') ||
                                Route::is('admin.role.right') ||
                                Route::is('admin.user.details') ||
                                Route::is('admin.driver') ||
                                Route::is('admin.driver.details') ||
                                Route::is('admin.dispatcher') ||
                                Route::is('admin.dispatcher.details') ||
                                Route::is('admin.user')) true @else false @endif"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div> Administration
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @if (Route::is('admin.role') ||
                            Route::is('admin.role.create') ||
                            Route::is('admin.role.edit') ||
                            Route::is('admin.role.right') ||
                            Route::is('admin.user.details') ||
                            Route::is('admin.driver') ||
                            Route::is('admin.driver.details') ||
                            Route::is('admin.dispatcher') ||
                            Route::is('admin.dispatcher.details') ||
                            Route::is('admin.user')) show @endif" id="setupNav"
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

                {{-- @if (Helper::hasRight('truck_type.view'))
                    <a class="nav-link {{ Route::is('admin.truck.type') ? 'active' : '' }}"
                        href="{{ route('admin.truck.type') }}" href="{{ route('admin.truck.type') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Truck Type Management
                    </a>
                @endif --}}

                <a class="nav-link {{ Route::is('admin.regular.video.free') ? 'active' : '' }}"
                    href="{{ route('admin.regular.video.free') }}" href="{{ route('admin.regular.video.free') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> নিয়মিত ভিডিও FREE
                </a>
                <a class="nav-link {{ Route::is('admin.amol.video.free') ? 'active' : '' }}"
                    href="{{ route('admin.amol.video.free') }}" href="{{ route('admin.amol.video.free') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> আমল ভিডিও FREE
                </a>
                <a class="nav-link {{ Route::is('admin.amol.video.premium') ? 'active' : '' }}"
                    href="{{ route('admin.amol.video.premium') }}" href="{{ route('admin.amol.video.premium') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> প্রিমিয়াম আমল ভিডিও
                </a>
                <a class="nav-link {{ Route::is('admin.video.premium') ? 'active' : '' }}"
                    href="{{ route('admin.video.premium') }}" href="{{ route('admin.video.premium') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> প্রিমিয়াম ভিডিও
                </a>
                <a class="nav-link {{ Route::is('admin.live.channel') ? 'active' : '' }}"
                    href="{{ route('admin.live.channel') }}" href="{{ route('admin.live.channel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Live Channel
                </a>
                <a class="nav-link {{ Route::is('admin.total.message') ? 'active' : '' }}"
                    href="{{ route('admin.total.message') }}" href="{{ route('admin.total.message') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Massage Total Massage
                </a>
                <a class="nav-link {{ Route::is('admin.payment.request') ? 'active' : '' }}"
                    href="{{ route('admin.payment.request') }}" href="{{ route('admin.payment.request') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Payment Requst
                </a>
                <a class="nav-link {{ Route::is('admin.tafsir') ? 'active' : '' }}"
                    href="{{ route('admin.tafsir') }}" href="{{ route('admin.tafsir') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> তাসফীর
                </a>
                <a class="nav-link {{ Route::is('admin.all.user') ? 'active' : '' }}"
                    href="{{ route('admin.all.user') }}" href="{{ route('admin.all.user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> All User
                </a>
                <a class="nav-link {{ Route::is('admin.paid.user') ? 'active' : '' }}"
                    href="{{ route('admin.paid.user') }}" href="{{ route('admin.paid.user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Paid User
                </a>
                <a class="nav-link {{ Route::is('admin.paid.user') ? 'active' : '' }}"
                    href="{{ route('admin.paid.user') }}" href="{{ route('admin.paid.user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> App Seting
                </a>
                <a class="nav-link {{ Route::is('admin.custom.ads') ? 'active' : '' }}"
                    href="{{ route('admin.custom.ads') }}" href="{{ route('admin.custom.ads') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Custom Ads
                </a>
            </div>
        </div>
    </nav>
</div>
