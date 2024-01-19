<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="createUserForm" action="{{ route('admin.truck.type.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Truck Type</h5>
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
                            <input type="file" id="profile_image" name="image"
                                        class="d-none" onchange="previewImage(this, '#createModal .preview_image')" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Truck Type Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Rent Type</label>
                        <div class="col-sm-10">
                            <select name="rent_type" class="form-control" id="rent_type" onchange="rentTypeChangeHandler(this, 'createModal')" required>
                                <option value="">Select Rent Type</option>
                                <option value="distance">Rent based on distance</option>
                                <option value="load">Rent based on load</option>
                            </select>
                        </div>
                    </div>
                    <div class="rent_amount_container">
                        <div class="form-group row">
                            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Rent amount</label>
                            <div class="col-sm-10">
                                <input type="number" name="rent_amount[]" class="form-control" placeholder="Rent amount" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Driver charge</label>
                        <div class="col-sm-10">
                            <input type="number" name="driver_charge" class="form-control" placeholder="Driver charge" required>
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
