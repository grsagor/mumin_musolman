<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.role.right.store') }}" method="post">
                @csrf 
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Right</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group  row">
                        <label for="" class="col-sm-3 col-form-label">Module Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="module_name" class="form-control" placeholder="eg: user" required>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="" class="col-sm-3 col-form-label">Right Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="right_name" class="form-control" placeholder="eg: view/ create/ edit/ delete" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary ">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit modal  --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>