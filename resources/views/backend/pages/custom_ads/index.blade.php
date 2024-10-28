@extends('backend.layout.app')
@section('title', 'Custom Ads | Mumin Musolman')
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
        <h4 class="mt-2">Custom Ads</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0">List</h5>
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
                            <th>Image</th>
                            <th>Ad No</th>
                            <th>Link</th>
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
    @include('backend.pages.custom_ads.modal')
    @push('footer')
        <script type="text/javascript">
            function getusers(name = null, email = null, phone = null) {
                var table = jQuery('#dataTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('admin/custom-ads/get/list') }}",
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
                            data: 'image',
                            name: 'image'
                        },
                        {
                            data: 'ad_no',
                            name: 'ad_no'
                        },
                        {
                            data: 'link',
                            name: 'link'
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
                let name = $('#filter_form #name').val();
                let email = $('#filter_form #email').val();
                let phone = $('#filter_form #phone').val();

                $('#dataTable').DataTable().destroy();
                getusers(name, email, phone);
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
                    url: "{{ route('admin.custom.ads.edit') }}",
                    type: "GET",
                    data: { id: id },
                    dataType: "html",
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
                            url: "{{ route('admin.custom.ads.delete') }}",
                            type: "GET",
                            data: { id:id },
                            dataType: "json",
                            success: function(data) {
                                if (data.type == 'success') {
                                    $.toast({
                                        heading: 'Success',
                                        text: data.message,
                                        position: 'top-center',
                                        icon: 'success'
                                    })
                                } else {
                                    $.toast({
                                        heading: 'Error',
                                        text: data.message,
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

            function incrementRow(first_div, second_div, copy_single = null) {
                console.log(copy_single);
                if (copy_single == null) {
                    var maindiv = $('.' + first_div);
                } else {
                    var maindiv = $(copy_single).closest('.' + first_div);
                }
                var copydiv = maindiv.find('.' + second_div + ':last');
                var clonedDiv = copydiv.clone(true);
                var rowNumber = parseInt(copydiv.attr('data-row-no')) + 1;
                clonedDiv.attr('data-row-no', rowNumber);
                clonedDiv.insertAfter(copydiv);
            }

            function removeRow(event) {
                event.preventDefault();
                var row = event.target.closest('tr');
                row.remove();
            }
        </script>
    @endpush
@endsection
