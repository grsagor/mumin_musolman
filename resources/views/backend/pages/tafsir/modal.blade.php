<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="createUserForm" action="{{ route('admin.tafsir.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
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
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Sura NO</label>
                        <div class="col-sm-10">
                            <input type="text" name="sura_no" class="form-control" placeholder="Sura NO" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Ayat NO</label>
                        <div class="col-sm-10">
                            <input type="text" name="ayat_no" class="form-control" placeholder="Ayat NO" required>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">জাকারিয়ার হেডিং</label>
                        <div class="col-sm-10">
                            <input type="text" name="jakariya_heading" class="form-control" placeholder="জাকারিয়ার হেডিং" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">জাকারিয়ার তাসফীর</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="jakariya_tafsir" class="form-control" placeholder="জাকারিয়ার তাসফীর" required></textarea>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">মাজিদ হেডিং</label>
                        <div class="col-sm-10">
                            <input type="text" name="majid_heading" class="form-control" placeholder="মাজিদ হেডিং" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">মাজিদ তাসফীর</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="majid_tafsir" class="form-control" placeholder="মাজিদ তাসফীর" required></textarea>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">আহসানুল হেডিং</label>
                        <div class="col-sm-10">
                            <input type="text" name="ahsanul_heading" class="form-control" placeholder="আহসানুল হেডিং" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">আহসানুল তাসফীর</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="ahsanul_tafsir" class="form-control" placeholder="আহসানুল তাসফীর" required></textarea>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">কাসির হেডিং</label>
                        <div class="col-sm-10">
                            <input type="text" name="kasir_heading" class="form-control" placeholder="কাসির হেডিং" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">কাসির তাসফীর</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="kasir_tafsir" class="form-control" placeholder="কাসির তাসফীর" required></textarea>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">অন্য আন্য হেডিং</label>
                        <div class="col-sm-10">
                            <input type="text" name="other_heading" class="form-control" placeholder="অন্য আন্য হেডিং" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">অন্য আন্য তাসফীর</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="other_tafsir" class="form-control" placeholder="অন্য আন্য তাসফীর" required></textarea>
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
