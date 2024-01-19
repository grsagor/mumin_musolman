@extends('backend.layout.app')
@section('title', 'Role | '.Helper::getSettings('application_name') ?? 'Truck Ease')
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Role Create</h4>

        <div class="card my-2">
            <div class="card-body">
                <form action="{{ route('admin.role.store') }}" method="post" id="permission_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="">Role Name</label>
                            <input type="text" class="form-control" name="role_name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <table class="col-lg-12 table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>Module Name</th>
                                        <th>Rights</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="pl-2"><b class="text-capitalize">Select All:</b></span></td>
                                        <td><label for=""><input type="checkbox" id="selectall"> Select all</label></td>
                                    </tr>
                                    @foreach ($rights as $right)
                                        <tr>
                                            <td><span class="pl-2"><b class="text-capitalize">{{ $right->module }}:</b></span></td>
                                            <td>
                                                @foreach($right->rights as $row)
                                                    <label for="" class="role-label"><input type="checkbox" class="permission-check" name="permission[{{$row->module}}][{{$row->id}}]" value="1"> {{ explode('.', $row->name)[1] }} </label>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 form-group text-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('footer')
        <script type="text/javascript">
            $('#selectall').change(function(){
                $('#permission_form input:checkbox').not(this).prop('checked', this.checked);
                if($(this).is(':checked')){
                    $('#permission_form input:checkbox').not(this).val(1);
                }else{
                    $('#permission_form input:checkbox').not(this).val(0);
                }
            });
        </script>
    @endpush
@endsection
