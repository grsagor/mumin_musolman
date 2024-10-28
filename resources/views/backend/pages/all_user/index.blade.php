@extends('backend.layout.app')
@section('title', 'All User | Mumin Musolman')
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
        <h4 class="mt-2 mb-3">All User Management</h4>

        <div class="card my-2">
            <div class="card-body pb-0 mb-3">
                <form method="" id="filter_form">
                    <div class="row">
                        <div class="col-md-10">
                            <select name="user_type" class="form-control" id="user_type" required>
                                <option value="">Select User Type</option>
                                <option value="chat">Chat Premium</option>
                                <option value="premium">Premium</option>
                                <option value="normal">Normal</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group text-end m-0">
                                <button type="submit" id="filterBtn" name="submit" class="btn btn-primary w-100"><i
                                        class="feather icon-file mr-2"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">All User List</h5>
                        </div>
                        @if (Helper::hasRight('user.create'))
                            <button type="button" class="btn btn-primary btn-create-user create_form_btn"
                                data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i>
                                Add</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
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
    @include('backend.pages.all_user.modal')
    @push('footer')
        <script type="text/javascript">
            function getusers(user_type = null) {
                var table = jQuery('#dataTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('admin/all-user/get/list') }}",
                        type: 'GET',
                        data: {
                            'user_type': user_type
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
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'address',
                            name: 'address'
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
                            "className": "text-center w-10"
                        },
                    ]
                });
            }
            getusers();

            $(document).on('click', '#filterBtn', function(e) {
                e.preventDefault();
                let user_type = $('#user_type').val();
                $('#dataTable').DataTable().destroy();
                getusers(user_type);
            })

            $(document).on('click', '#createUserBtn', function(e) {
                e.preventDefault();
                let go_next_step = true;
                if ($(this).attr('data-check-area') && $(this).attr('data-check-area').trim() !== '') {
                    go_next_step = check_validation_Form('#createModal .' + $(this).attr('data-check-area'));
                }
                if (go_next_step == true) {
                    let form = document.getElementById('createUserForm');
                    var formData = new FormData(form);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: $('#createUserForm').attr('action'),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                position: 'top-center',
                                icon: 'success'
                            })
                            $('#dataTable').DataTable().destroy();
                            getusers();
                            $('#createModal').modal('hide');
                        },
                        error: function(xhr) {
                            let errorMessage = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += ('' + value + '<br>');
                            });
                            $('#createUserForm .server_side_error').html(
                                '<div class="alert alert-danger" role="alert">' + errorMessage +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            );
                        },
                    })
                }
            })

            $(document).on('click', '.edit_btn', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ url('/admin/all-user/edit') }}",
                    type: "GET",
                    dataType: "html",
                    data: {id: id},
                    success: function(data) {
                        $('#editModal .modal-content').html(data);
                        $('#editModal').modal('show');
                    }
                })
            });

            $(document).on('click', '#editUserBtn', function(e) {
                e.preventDefault();
                let go_next_step = true;
                if ($(this).attr('data-check-area') && $(this).attr('data-check-area').trim() !== '') {
                    go_next_step = check_validation_Form('#editModal .' + $(this).attr('data-check-area'));
                }
                if (go_next_step == true) {
                    let form = document.getElementById('editUserForm');
                    var formData = new FormData(form);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: $('#editUserForm').attr('action'),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                position: 'top-center',
                                icon: 'success'
                            })
                            $('#dataTable').DataTable().destroy();
                            getusers();
                            $('#editModal').modal('hide');
                        },
                        error: function(xhr) {
                            let errorMessage = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += ('' + value + '<br>');
                            });
                            $('#editUserForm .server_side_error').html(
                                '<div class="alert alert-danger" role="alert">' + errorMessage +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            );
                        },
                    })
                }
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
                            url: "{{ url('/admin/user/delete/') }}/" + id,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                if (data.success) {
                                    $.toast({
                                        heading: 'Success',
                                        text: data.success,
                                        position: 'top-center',
                                        icon: 'success'
                                    })
                                } else {
                                    $.toast({
                                        heading: 'Error',
                                        text: data.error,
                                        position: 'top-center',
                                        icon: 'error'
                                    })
                                }
                                $('#dataTable').DataTable().destroy();
                                getusers();
                            }
                        })

                    }
                })
            })


            $(document).on('click', '.change_password', function(e) {
                e.preventDefault();
                let form = $('#changePasswordModal').find('form');
                form[0].reset();
                $('#changePasswordModal .server_side_error').empty();
                $('#changePasswordModal input[required]').each(function() {
                    $(this).css("border-color", "#d4d4d4");
                    $(this).next('.error-tag').remove();
                });
                let id = $(this).attr('data-id');
                $('#changePasswordModal #user_id').val(id);
                $('#changePasswordModal').modal('show');
            })

            $(document).on('click', '#changePasswordBtn', function(e) {
                e.preventDefault();
                let go_next_step = true;
                if ($(this).attr('data-check-area') && $(this).attr('data-check-area').trim() !== '') {
                    go_next_step = check_validation_Form('#changePasswordModal .' + $(this).attr('data-check-area'));
                }
                if (go_next_step == true) {
                    let form = document.getElementById('changePasswordForm');
                    var formData = new FormData(form);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: $('#changePasswordForm').attr('action'),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                position: 'top-center',
                                icon: 'success'
                            })
                            $('#dataTable').DataTable().destroy();
                            getusers();
                            $('#changePasswordModal').modal('hide');
                        },
                        error: function(xhr) {
                            let errorMessage = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += ('' + value + '<br>');
                            });
                            $('#changePasswordForm .server_side_error').html(
                                '<div class="alert alert-danger" role="alert">' + errorMessage +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            );
                        },
                    })
                }
            })
        </script>

        <script>
            function previewImage(input, previewContainerClass) {
                var preview = document.querySelector(previewContainerClass);
                console.log(previewContainerClass)
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
