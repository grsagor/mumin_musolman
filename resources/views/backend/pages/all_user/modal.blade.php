<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="createUserForm" action="{{ route('admin.all.user.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        {{-- <i class="fa-solid fa-xmark"></i> --}}
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
                                    for="profile_image">
                                    <img class="w-100 h-100 object-fit-cover preview_image"
                                        src="{{ asset('assets/img/ui/no-image.png') }}" alt="">
                                </label>
                                <div
                                    class="profile_picture_edit_icon--container bg-white position-absolute d-flex flex-column align-items-center justify-content-center rounded-circle shadow">
                                    <i class="fa-solid fa-pen text-primary text-12"></i>
                                </div>
                            </div>
                            <input type="file" id="profile_image" name="profile_image"
                                        class="d-none" onchange="previewImage(this, '#createModal .preview_image')" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Phone No.</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" class="form-control" placeholder="Phone No." required>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <select name="gender" class="form-control" id="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="address" class="text-gray-700 fw-medium col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea id="address" type="text" class="form-control h-auto resize-none" name="address" placeholder="Address" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-4 d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status"
                                    id="flexSwitchCheckDefault" checked>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
                    <button type="submit" id="createUserBtn" class="btn btn-primary"
                        data-check-area="modal-body">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit modal  --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

{{-- edit modal  --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="changePasswordForm" action="{{ route('admin.user.changepassword') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change User Password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="server_side_error" role="alert">

                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group ">
                        <label for="">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
                    <button type="submit" id="changePasswordBtn" class="btn btn-primary"
                        data-check-area="modal-body">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
