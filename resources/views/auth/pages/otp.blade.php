@extends('auth.include.app')
@section('title', 'Change Password')
@section('content')
    <h3 class="text-left w-100 mb-3">Change Password</h3>
    @if ($errors->any())
        <div class="alert alert-danger w-100">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible w-100">
            <p class="mb-0">{{ Session::get('message') }}</p>
        </div>
    @endif
    <form class="w-100" action="{{ url('change-password') }}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input class="form-control" id="inputEmail" type="email" name="email"
                placeholder="name@example.com" value="{{ $email ?? '' }}" required />
            <label for="inputEmail">{{ trans('language.label_e_mail') }} <span class="text-danger">*</span></label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="inputEmail" type="text" name="otp"
                placeholder="234897" required />
            <label for="inputEmail">{{ trans('language.label_otp') }} <span class="text-danger">*</span></label>
        </div>
        <div class="form-floating mb-3 position-relative">
            <input class="form-control" id="inputEmail" type="text" name="password" required />
            <label for="inputEmail">{{ trans('language.label_new_password') }}<span class="text-danger">*</span></label>
            <div class="eye-icon-container position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
                <button type="button" class="btn eye-icon-btn"><i class="fa-regular fa-eye-slash"></i></button>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control position-relative" id="inputEmail" type="text" name="password_confirmation" required />
            <label for="inputEmail">{{ trans('language.label_confirm_password') }}<span class="text-danger">*</span></label>
            <div class="eye-icon-container position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
                <button type="button" class="btn eye-icon-btn"><i class="fa-regular fa-eye-slash"></i></button>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" class="btn btn-primary w-100">{{ trans('language.btn_change_password') }}</button>
        </div>
    </form>

    <div class="my-3 text-center">
        <p class="mb-0">Don’t have an account? <a href="{{ route('register') }}" class="text-primary">Register</a></p>
    </div>

@endsection
