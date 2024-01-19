<form action="{{ route('admin.role.right.update', $right->id)}}" method="post">
    @csrf 
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Right</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group  row">
            <label for="" class="col-sm-3 col-form-label">Module Name</label>
            <div class="col-sm-9">
                <input type="text" name="module_name" class="form-control" value="{{ $right->module }}" placeholder="eg: user" required>
            </div>
        </div>

        <div class="form-group  row">
            <label for="" class="col-sm-3 col-form-label">Right Name</label>
            <div class="col-sm-9">
                <input type="text" name="right_name" value="{{ explode('.', $right->name)[1] }}" class="form-control" placeholder="eg: view/ create/ edit/ delete" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>