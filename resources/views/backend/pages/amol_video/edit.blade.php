<form id="editUserForm" action="{{ route('admin.truck.type.update') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $truck_details->id }}">
    <input type="hidden" name="truck_type_id" value="{{ $truck_details->truck_type->id }}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
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
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10">
                <div class="profile_image_input--container position-relative">
                    <label class="w-100 h-100 rounded-circle overflow-hidden bg-blue-100 cursor-pointer"
                        for="edit_profile_image">
                        <img class="w-100 h-100 object-fit-cover preview_image"
                            src="{{ $truck_details->truck_type->image ? asset($truck_details->truck_type->image) : asset('assets/img/ui/no-image.png') }}"
                            alt="">
                        <input type="file" id="edit_profile_image" name="image" class="form-control d-none"
                            placeholder="Name" onchange="previewImage(this, '#editUserForm .preview_image')">
                    </label>
                    <div
                        class="profile_picture_edit_icon--container bg-white position-absolute d-flex flex-column align-items-center justify-content-center rounded-circle shadow">
                        <i class="fa-solid fa-pen text-primary text-12"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10">
                <input type="text" name="name" value="{{ $truck_details->truck_type->name }}" class="form-control"
                    placeholder="Item" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10">
                <select name="rent_type" class="form-control" id="rent_type"
                    onchange="rentTypeChangeHandler(this, 'createModal')" required>
                    <option value="">Item</option>
                    <option {{ $truck_details->truck_type->rent_type == 'distance' ? 'selected' : '' }}
                        value="distance">Item</option>
                    <option {{ $truck_details->truck_type->rent_type == 'load' ? 'selected' : '' }} value="load">Item</option>
                </select>
            </div>
        </div>
        <div class="rent_amount_container">
            <div class="form-group row">
                <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Item</label>

                @if ($truck_details->truck_type->rent_type == 'distance')
                    <div class="col-sm-10">
                        <input type="number" name="rent_amount[]" value="{{ $truck_details->rent_amount }}"
                            class="form-control" placeholder="Item" required>
                    </div>
                @endif
                @if ($truck_details->truck_type->rent_type == 'load')
                    <div class="col-sm-10 d-flex gap-2">
                        <input type="text" name="load_type" value="{{ $truck_details->load_type }}" class="form-control" placeholder="Item" required>
                        <input type="number" name="rent_amount" value="{{ $truck_details->rent_amount }}" class="form-control" placeholder="Item"
                            required>
                    </div>
                @endif

            </div>
        </div>
        <div class="form-group row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10">
                <input type="number" name="driver_charge" value="{{ $truck_details->truck_type->driver_charge }}"
                    class="form-control" placeholder="Item" required>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Status</label>
            <div class="col-sm-4 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckDefault"
                        {{ $truck_details->truck_type->status == 1 ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
        <button type="submit" id="editUserBtn" class="btn btn-primary" data-check-area="modal-body">Update</button>
    </div>
</form>
