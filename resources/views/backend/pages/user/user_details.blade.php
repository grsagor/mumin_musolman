@extends('backend.layout.app')
@section('title', 'User | Mumin Musolman')
@section('css')
    <style>
        .user_image--container {
            width: 64px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex gap-3 mt-2">
            <a href="{{ route('admin.user') }}" class="h-fit-content bg-transparent border-0 text-gray-500"><i class="fa-solid fa-arrow-left"></i> Back</a>
            <h4>User Profile</h4>
        </div>

        <div class="card my-2">
            <div class="card-body pb-0">
                <div class="mb-3 d-flex gap-3">
                    <div class="user_image--container aspect-ratio-1x1 rounded-circle overflow-hidden">
                        <img class="w-100 h-100 object-fit-cover" src="{{ asset($user->profile_image_path) }}" alt="">
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                        <h6 class="text-24 text-gray-900 fw-semibold m-0">{{ $user->name }}</h6>
                        <p class="fw-medium text-gray-900">{{ $user->id }}</p>
                    </div>
                </div>

                <div class="fw-medium mb-3">
                    <p><span class="text-gray-600">Email: </span><span>{{ $user->email }}</span></p>
                    <p><span class="text-gray-600">Phone: </span><span>{{ $user->phone }}</span></p>
                    <p><span class="text-gray-600">Gender: </span><span>{{ $user->gender }}</span></p>
                    <p><span class="text-gray-600">Address: </span><span>{{ $user->address }}</span></p>
                </div>

                <div class="mb-3 fw-medium">
                    <p class="d-flex align-items-center gap-2">
                        <span class="text-gray-600">Status: </span>
                        <span class="text-24">
                            @if ($user->status == 1)
                                <i class="fa-solid fa-toggle-on text-primary"></i>
                            @else
                                <i class="fa-solid fa-toggle-off text-gray-600"></i>
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">Total Service</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Rid ID</th>
                            <th>Pickup location</th>
                            <th>Drop location</th>
                            <th>Pick Time</th>
                            <th>Truck Type</th>
                            <th>Driver</th>
                            <th>Load Type</th>
                            <th>Distance</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>RID123345</td>
                            <td>Portland, Illinois</td>
                            <td>Syracuse, Connecticut</td>
                            <td>Fri 26 Jun,20 12:30 am</td>
                            <td>11</td>
                            <td>Jenny</td>
                            <td>House Furniture</td>
                            <td>100 KM</td>
                            <td>$300</td>
                            <td><i class="fa-solid fa-download"></i></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>RID123345</td>
                            <td>Portland, Illinois</td>
                            <td>Syracuse, Connecticut</td>
                            <td>Fri 26 Jun,20 12:30 am</td>
                            <td>11</td>
                            <td>Jenny</td>
                            <td>House Furniture</td>
                            <td>100 KM</td>
                            <td>$300</td>
                            <td><i class="fa-solid fa-download"></i></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>RID123345</td>
                            <td>Portland, Illinois</td>
                            <td>Syracuse, Connecticut</td>
                            <td>Fri 26 Jun,20 12:30 am</td>
                            <td>11</td>
                            <td>Jenny</td>
                            <td>House Furniture</td>
                            <td>100 KM</td>
                            <td>$300</td>
                            <td><i class="fa-solid fa-download"></i></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>RID123345</td>
                            <td>Portland, Illinois</td>
                            <td>Syracuse, Connecticut</td>
                            <td>Fri 26 Jun,20 12:30 am</td>
                            <td>11</td>
                            <td>Jenny</td>
                            <td>House Furniture</td>
                            <td>100 KM</td>
                            <td>$300</td>
                            <td><i class="fa-solid fa-download"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.pages.user.modal')
    @push('footer')
        <script type="text/javascript">
            function getusers(name = null, email = null, phone = null) {
                var table = jQuery('#dataTable').DataTable();
            }
            getusers();
        </script>
    @endpush
@endsection
