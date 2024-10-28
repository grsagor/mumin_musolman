@extends('backend.layout.app')
@section('title', 'Dashboard | Mumin Musolman')
@section('content')
    <div class="container-fluid px-5 pt-4">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <div class="card bg-primary text-white p-3 d-flex flex-column justify-content-between h-100">
                    <p class="mb-3 fs-4">Total User</p>
                    <div class="d-flex align-items-center gap-2 fs-3">
                        <i class="fa-solid fa-users"></i>
                        <p class="text-center">{{ $total_users }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <div class="card bg-primary text-white p-3 d-flex flex-column justify-content-between h-100">
                    <p class="mb-3 fs-4">Premium User</p>
                    <div class="d-flex align-items-center gap-2 fs-3">
                        <i class="fa-solid fa-users"></i>
                        <p class="text-center">{{ $premium_users }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <div class="card bg-primary text-white p-3 d-flex flex-column justify-content-between h-100">
                    <p class="mb-3 fs-4">Message Premium User</p>
                    <div class="d-flex align-items-center gap-2 fs-3">
                        <i class="fa-solid fa-users"></i>
                        <p class="text-center">{{ $chat_users }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <div class="card bg-primary text-white p-3 d-flex flex-column justify-content-between h-100">
                    <p class="mb-3 fs-4">Total Transaction</p>
                    <div class="d-flex align-items-center gap-2 fs-3">
                        <i class="fa-solid fa-users"></i>
                        <p class="text-center">{{ $total_transaction }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


