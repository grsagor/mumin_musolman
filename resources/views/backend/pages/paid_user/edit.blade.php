<form id="editUserForm" action="{{ route('admin.user.update', $user->id)}}" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="server_side_error" role="alert">

            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Add Image</label>
            <div class="col-sm-10">
                <div class="profile_image_input--container position-relative">
                    <label class="w-100 h-100 rounded-circle overflow-hidden bg-blue-100 cursor-pointer"
                        for="edit_profile_image">
                        <img class="w-100 h-100 object-fit-cover preview_image"
                            src="{{ $user->profile_image ? asset($user->profile_image) : asset('assets/img/ui/no-image.png') }}" alt="">
                        <input type="file" id="edit_profile_image" name="profile_image"
                            class="form-control d-none" placeholder="Name" onchange="previewImage(this, '#editUserForm .preview_image')">
                    </label>
                    <div
                        class="profile_picture_edit_icon--container bg-white position-absolute d-flex flex-column align-items-center justify-content-center rounded-circle shadow">
                        <i class="fa-solid fa-pen text-primary text-12"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}" required>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Phone No.</label>
            <div class="col-sm-10">
                <input type="text" name="phone" class="form-control" placeholder="Phone No." value="{{ $user->phone }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Gender</label>
            <div class="col-sm-10">
                <select name="gender" class="form-control" id="gender">
                    <option value="">Select Gender</option>
                    <option {{ $user->gender == 'male' ? 'selected' : '' }} value="male">Male</option>
                    <option {{ $user->gender == 'female' ? 'selected' : '' }} value="female">Female</option>
                    <option {{ $user->gender == 'other' ? 'selected' : '' }} value="other">Other</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="text-gray-700 fw-medium col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <textarea id="address" type="text" class="form-control h-auto resize-none" name="address" placeholder="Address" rows="5">{{ $user->address }}</textarea>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Status</label>
            <div class="col-sm-4 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input {{ $user->status ? 'checked' : '' }} class="form-check-input" type="checkbox" name="status"
                        id="flexSwitchCheckDefault">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
        <button type="submit" id="editUserBtn" class="btn btn-primary" data-check-area="modal-body">Update</button>
    </div>
</form>
