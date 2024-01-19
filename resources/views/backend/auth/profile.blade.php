@extends('backend.layout.app')
@section('css')
<style>
.profile-image-plus-icon {
    display: none;
}
.profile-image-container:hover .profile-image-plus-icon {
    display: flex;
    color: white;
}
</style>
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6 offset-lg-3">
                <div class="card shadow border-0 rounded-lg mt-4">
                    <div class="card-header">
                        <h4 class="text-center my-2">Change Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-center mb-3">
                                <label for="profile_image" class="rounded-circle overflow-hidden cursor-pointer position-relative profile-image-container">
                                    <img class="border-redius-50 preview_img"
                                        src="{{ $user->profile_image ? asset($user->profile_image) : asset('assets/img/no-img.jpg') }}"
                                        alt="profile image" height="80px" width="80px">
                                        <div class="position-absolute start-0 end-0 top-0 bottom-0 flex-middle justify-content-center align-items-center profile-image-plus-icon">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                </label>
                            </div>

                            <div class="form-group mb-3 d-none">
                                <input class="form-control" type="file" name="profile_image" id="profile_image" />
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="name" value="{{ $user->name ?? '' }}"
                                    placeholder="Name" />
                                <label for="inputEmail">Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email"
                                    placeholder="name@example.com" value="{{ $user->email }}" readonly />
                                <label for="inputEmail">{{ trans('language.label_email') }}</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="text" name="phone"
                                    placeholder="{{ trans('language.label_phone') }}" value="{{ $user->phone ?? '' }}" />
                                <label for="inputEmail">{{ trans('language.label_phone') }}</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="submit"
                                    class="btn btn-primary w-100">{{ trans('language.btn_update_profile') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('footer')
        <script>
            $(document).on('change', '#profile_image', function(e) {
                e.preventDefault();
                let input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.preview_img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            })
        </script>
    @endpush
@endsection
