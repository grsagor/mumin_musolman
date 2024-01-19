@extends('auth.include.app')
@section('title', 'Login')
@section('content')
    <h3 class="text-center w-100 mb-3">Login</h3>
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
    <form class="w-100" method="post" action="{{ route('login.post') }}">
        @csrf
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" placeholder="{{ trans('language.label_email') }}"
                name="email" required>
            <label for="email">{{ trans('language.label_email') }} <span class="text-danger">*</span></label>
        </div>
        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control" id="password" placeholder="{{ trans('language.label_password') }}"
                name="password" required>
            <label for="password">{{ trans('language.label_password') }} <span class="text-danger">*</span></label>
            <div class="eye-icon-container position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
                <button type="button" class="btn eye-icon-btn"><i class="fa-regular fa-eye-slash"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-start mb-3">
            <a class="small " href="{{ url('reset-password') }}">{{ trans('language.label_forgot_password') }}?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">{{ trans('language.login') }}</button>
    </form>
@endsection
