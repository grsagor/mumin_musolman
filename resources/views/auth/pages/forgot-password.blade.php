@extends('auth.include.app')
@section('title', 'Reset Password')
@section('content')
    <h3 class="text-left w-100 mb-3">Reset Password</h3>
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
    <form class="w-100" action="{{ url('reset-otp-send') }}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input class="form-control" id="inputEmail" type="email" name="email"
                placeholder="name@example.com" required />
            <label for="inputEmail">{{ trans('language.label_email') }} <span class="text-danger">*</span></label>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" class="btn btn-primary w-100">{{ trans('language.btn_send_otp') }}</button>
        </div>
    </form>

    <div class="my-3 text-center">
        <p class="mb-0">Don’t have an account? <a href="{{ route('register') }}" class="text-primary">Register</a></p>
    </div>

@endsection
