@extends('backend.layout.app')
@section('title', 'Settings | '.Helper::getSettings('application_name') ?? 'Truck Ease' )
@section('content')
    <div class="container-fluid px-4">
        <h4 class="mt-2">Settings</h4>

        <div class="card my-2">
            <div class="card-header">
                <div class="row ">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center"><h5 class="m-0">Static Content</h5></div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <form action="{{ route('admin.setting.update') }}" id="settingForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">About Us:</label>
                        <div class="col-sm-9">
                            <textarea name="about_us" id="" class="tinymceText form-control" cols="30" rows="20">{!! Helper::getSettings('about_us') !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">About Page Images:</label>
                        <div class="col-sm-3">
                            <input type="file" class="form-control" onchange="previewFile('settingForm #about_image_1', 'settingForm .about_image_1_image')" name="about_image_1" id="about_image_1">
                            <img src="{{ Helper::getSettings('about_image_1') ? asset('uploads/settings/'.Helper::getSettings('about_image_1')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="about_image_1_image mt-1 border" alt="">
                        </div>
                        <div class="col-sm-3">
                            <input type="file" class="form-control" onchange="previewFile('settingForm #about_image_2', 'settingForm .about_image_2_image')" name="about_image_2" id="about_image_2">
                            <img src="{{ Helper::getSettings('about_image_2') ? asset('uploads/settings/'.Helper::getSettings('about_image_2')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="about_image_2_image mt-1 border" alt="">
                        </div>
                        <div class="col-sm-3">
                            <input type="file" class="form-control" onchange="previewFile('settingForm #about_image_3', 'settingForm .about_image_3_image')" name="about_image_3" id="about_image_3">
                            <img src="{{ Helper::getSettings('about_image_3') ? asset('uploads/settings/'.Helper::getSettings('about_image_3')) : asset('assets/img/no-img.jpg')}}" height="80px" width="100px" class="about_image_3_image mt-1 border" alt="">
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
