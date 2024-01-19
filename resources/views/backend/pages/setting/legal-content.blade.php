@extends('backend.layout.app')
@section('title', 'Settings | '.Helper::getSettings('application_name') ?? 'Truck Ease' )
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Settings</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center"><h5 class="m-0">Legal Content</h5></div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('admin.setting.update') }}" id="settingForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Terms and Conditions:</label>
                        <div class="col-sm-9">
                            <textarea name="terms_and_conditions" id="" class="tinymceText form-control" cols="30" rows="20">{!! Helper::getSettings('terms_and_conditions') !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Privacy Policy:</label>
                        <div class="col-sm-9">
                            <textarea name="privacy_policy" id="" class="tinymceText form-control" cols="30" rows="20">{!! Helper::getSettings('privacy_policy') !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Return Policy:</label>
                        <div class="col-sm-9">
                            <textarea name="return_policy" id="" class="tinymceText form-control" cols="30" rows="20">{!! Helper::getSettings('return_policy') !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('footer')
        <script type="text/javascript">

        </script>
    @endpush
@endsection
