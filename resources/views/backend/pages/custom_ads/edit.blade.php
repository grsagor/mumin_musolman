<form id="editUserForm" action="{{ route('admin.custom.ads.update') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $ad->id }}">
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
                            src="{{ $ad->image ? asset($ad->image) : asset('assets/img/ui/no-image.png') }}"
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
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Link</label>
            <div class="col-sm-10">
                <input type="text" name="link" class="form-control" value="{{ $ad->link }}" placeholder="Link" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Ad No</label>
            <div class="col-sm-10">
                <select name="ad_no" class="form-control" id="ad_no" required>
                    <option value="">Select Ad No</option>
                    <option {{ $ad->ad_no == "Ads 1" ? 'selected' : '' }} value="Ads 1">Ads 1</option>
                    <option {{ $ad->ad_no == "Ads 2" ? 'selected' : '' }} value="Ads 2">Ads 2</option>
                    <option {{ $ad->ad_no == "Ads 3" ? 'selected' : '' }} value="Ads 3">Ads 3</option>
                    <option {{ $ad->ad_no == "Ads 4" ? 'selected' : '' }} value="Ads 4">Ads 4</option>
                    <option {{ $ad->ad_no == "Ads 5" ? 'selected' : '' }} value="Ads 5">Ads 5</option>
                    <option {{ $ad->ad_no == "Banner" ? 'selected' : '' }} value="Banner">Display Ads</option>
                </select>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Status</label>
            <div class="col-sm-4 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckDefault"
                        {{ $ad->status == 1 ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
        <button type="submit" id="editUserBtn" class="btn btn-primary" data-check-area="modal-body">Update</button>
    </div>
</form>
