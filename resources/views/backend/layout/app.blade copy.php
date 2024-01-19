@include('backend.include.header')
<body class="sb-nav-fixed">
    @include('backend.include.topbar')
    <div id="layoutSidenav">
        @include('backend.include.sidebar')
        <div id="layoutSidenav_content">
            <main class="pt-4">
                @yield('content')
            </main>
            @include('backend.include.footer')
