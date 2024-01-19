@extends('backend.layout.app')
@section('title', 'Right | '.Helper::getSettings('application_name') ?? 'Truck Ease')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Right Management</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 text-end">
                        @if (Helper::hasRight('right.create'))
                            <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Add</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Right</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('backend.pages.right.modal')
    @push('footer')
        <script type="text/javascript">
            function getRight(search = null){
                var table = jQuery('#dataTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    // searching:false,
                    // paging:false,
                    // bFilter:false,
                    // bInfo:false,
                    ajax: {
                        url: "{{ url('admin/role/get/right/list') }}",
                        type: 'GET',
                        data:{
                        },
                    },
                    aLengthMenu: [
                        [25, 50, 100, 500, 5000, -1],
                        [25, 50, 100, 500, 5000, "All"]
                    ],
                    iDisplayLength: 50,
                    "order": [
                        [ 0, 'desc' ]
                    ],
                    columns: [
                        {
                            data: 'module',
                        },
                        {
                            data: 'name',
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

            getRight();

            $(document).on('click', '.edit_btn', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                $.ajax({
                    url: "{{  url('/admin/role/right/edit/') }}/"+id,
                    type: "GET",
                    dataType: "html",
                    success: function (data) {
                        $('#editModal .modal-content').html(data);
                        $('#editModal').modal('show');
                    }
                })
            });

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
                            url: "{{  url('/admin/role/right/delete/') }}/"+id,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
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
                                getRight();
                            }
                        })

                    }
                })
            })

        </script>
    @endpush
@endsection
