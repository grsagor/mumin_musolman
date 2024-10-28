@extends('backend.layout.app')
@section('title', 'Message Request | Mumin Musolman')
@section('css')
    <style>
        .profile_image_input--container {
            width: 100px;
            height: 100px;
        }

        .profile_picture_edit_icon--container {
            width: 24px;
            height: 24px;
            bottom: 3px;
            right: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Message Request</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">List</h5>
                        </div>
                        {{-- @if (Helper::hasRight('user.create'))
                            <button type="button" class="btn btn-primary btn-create-user create_form_btn"
                                data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i>
                                Add</button>
                        @endif --}}
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>UserID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.pages.message-request.modal')
    @push('footer')
        <script type="text/javascript">
            function getusers(name = null, email = null, phone = null) {
                var table = jQuery('#dataTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.message.requests.get.list') }}",
                        type: 'GET',
                        data: {
                            'name': name,
                            'email': email,
                            'phone': phone
                        },
                    },
                    aLengthMenu: [
                        [25, 50, 100, 500, 5000, -1],
                        [25, 50, 100, 500, 5000, "All"]
                    ],
                    iDisplayLength: 25,
                    "order": [
                        [2, 'asc']
                    ],
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            },
                            "className": "text-center"
                        },
                        {
                            data: 'user_id',
                            name: 'user_id',
                            "className": "text-center"
                        },
                        {
                            data: 'name',
                            name: 'name',
                            "className": "text-center"
                        },
                        {
                            data: 'status',
                            name: 'status',
                            "className": "text-center"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            "className": "text-center w-20"
                        },
                    ]
                });
            }
            getusers();

            $(document).on('click', '.accept_btn', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.message.requests.accept') }}",
                            type: "GET",
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function(data) {
                                $.toast({
                                    heading: 'Success',
                                    text: data.message,
                                    position: 'top-center',
                                    icon: 'success'
                                })
                                $('#dataTable').DataTable().destroy();
                                getusers();
                            }
                        })

                    }
                })
            })
            $(document).on('click', '.cancel_btn', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.message.requests.cancel') }}",
                            type: "GET",
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function(data) {
                                $.toast({
                                    heading: 'Success',
                                    text: data.message,
                                    position: 'top-center',
                                    icon: 'success'
                                })
                                $('#dataTable').DataTable().destroy();
                                getusers();
                            }
                        })

                    }
                })
            })
            $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.message.requests.delete') }}",
                            type: "GET",
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function(data) {
                                $.toast({
                                    heading: 'Success',
                                    text: data.message,
                                    position: 'top-center',
                                    icon: 'success'
                                })
                                $('#dataTable').DataTable().destroy();
                                getusers();
                            }
                        })

                    }
                })
            })
        </script>
    @endpush
@endsection
