@extends('backend.layout.app')
@section('title', 'Settings | Mumin Musolman' )
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Settings</h4>

        <div class="my-2 card">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center"><h5 class="m-0">General Setting</h5></div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('admin.setting.update') }}" id="settingForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Change Bkash Number:</label>
                        <div class="col-sm-9">
                            <input type="text" name="bkash_number" value="{{ Helper::getSettings('bkash_number') }}" class="form-control" placeholder="Change Bkash Number" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Change Nagad Number:</label>
                        <div class="col-sm-9">
                            <input type="text" name="nagad_number" value="{{ Helper::getSettings('nagad_number') }}" class="form-control" placeholder="Change Nagad Number" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Message charge:</label>
                        <div class="col-sm-9">
                            <input type="text" name="message_charge" value="{{ Helper::getSettings('message_charge') }}" class="form-control" placeholder="Message charge" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Message validity:</label>
                        <div class="col-sm-9">
                            <input type="text" name="message_validity" value="{{ Helper::getSettings('message_validity') }}" class="form-control" placeholder="Message validity" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Premium video & amol charge:</label>
                        <div class="col-sm-9">
                            <input type="text" name="premium_charge" value="{{ Helper::getSettings('premium_charge') }}" class="form-control" placeholder="Premium video & amol charge" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Premium video & amol validity:</label>
                        <div class="col-sm-9">
                            <input type="text" name="premium_validity" value="{{ Helper::getSettings('premium_validity') }}" class="form-control" placeholder="Premium video & amol validity" >
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
