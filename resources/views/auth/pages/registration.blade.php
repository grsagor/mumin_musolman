@extends('auth.include.app')
@section('title', 'Register')
@section('content')
    <h3 class="text-left w-100 mb-3">Register</h3>
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
    <form class="w-100" action="{{ route('registration.post') }}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
            <label for="password">Password</label>
            <div class="eye-icon-container position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
                <button type="button" class="btn eye-icon-btn"><i class="fa-regular fa-eye-slash"></i></button>
            </div>
        </div>
        <div class="form-floating mb-3 position-relative">
            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password"
                name="password_confirmation" required>
            <label for="confirm_password">Confirm Password</label>
            <div class="eye-icon-container position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
                <button type="button" class="btn eye-icon-btn"><i class="fa-regular fa-eye-slash"></i></button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <div class="my-3">
        <p>Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a></p>
    </div>

@endsection
