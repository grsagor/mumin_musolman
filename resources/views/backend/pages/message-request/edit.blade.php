<form id="editUserForm" action="{{ route('admin.amol.video.free.update') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $video->id }}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
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
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $video->title }}" required>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Short Description</label>
            <div class="col-sm-10">
                <input type="text" name="short_description" class="form-control" placeholder="Short Description" value="{{ $video->short_description }}" required>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Embed Link</label>
            <div class="col-sm-10">
                <input type="text" name="embed_link" class="form-control" placeholder="Embed Link" value="{{ $video->embed_link }}" required>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Status</label>
            <div class="col-sm-4 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckDefault"
                        {{ $video->status == 1 ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
        <button type="submit" id="editUserBtn" class="btn btn-primary" data-check-area="modal-body">Update</button>
    </div>
</form>
