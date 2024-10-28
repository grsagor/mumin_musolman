<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Mumin Musolman</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
</head>

<body>
    <div class="row justify-content-center w-100 auth-container">
        <div class="col-12 col-lg-4 d-flex flex-column justify-content-center align-items-center px-5 overflow-y-auto py-5">
            <div class="mb-3">
                <img src="{{ asset('uploads/settings/170533711865a5611ec2009unnamed.webp') }}" width="70px" alt="Logo">
            </div>
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jQuery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.eye-icon-btn').click(function() {
                var iconElement = $(this).find('i');
                iconElement.toggleClass('fa-eye fa-eye-slash');

                var grandparentDiv = $(this).parent().parent();
                var inputElement = grandparentDiv.find('input');
                if (inputElement.attr('type') === 'text') {
                    inputElement.attr('type', 'password');
                } else {
                    inputElement.attr('type', 'text');
                }
            })
        })
    </script>
</body>

</html>
