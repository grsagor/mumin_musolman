<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="createUserForm" action="{{ route('admin.custom.ads.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
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
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Choose Image</label>
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
                            <input type="file" id="profile_image" name="image"
                                        class="d-none" onchange="previewImage(this, '#createModal .preview_image')" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Link</label>
                        <div class="col-sm-10">
                            <input type="text" name="link" class="form-control" placeholder="Link" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Item</label>
                        <div class="col-sm-10">
                            <select name="ad_no" class="form-control" id="ad_no" required>
                                <option value="">Select Item</option>
                                <option value="Ads 1">Ads 1</option>
                                <option value="Ads 2">Ads 2</option>
                                <option value="Ads 3">Ads 3</option>
                                <option value="Ads 4">Ads 4</option>
                                <option value="Ads 5">Ads 5</option>
                                <option value="Ads 6">Ads 6</option>
                            </select>
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
