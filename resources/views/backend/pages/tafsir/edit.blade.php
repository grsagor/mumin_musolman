<form id="editUserForm" action="{{ route('admin.tafsir.update') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $tafsir->id }}">
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
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Sura NO</label>
            <div class="col-sm-10">
                <input type="text" name="sura_no" class="form-control" placeholder="Sura NO" required value="{{ $tafsir->sura_no }}">
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Ayat NO</label>
            <div class="col-sm-10">
                <input type="text" name="ayat_no" class="form-control" placeholder="Ayat NO" required value="{{ $tafsir->ayat_no }}">
            </div>
        </div>

        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">জাকারিয়ার হেডিং</label>
            <div class="col-sm-10">
                <input type="text" name="jakariya_heading" class="form-control" placeholder="জাকারিয়ার হেডিং" required value="{{ $tafsir->jakariya_heading }}">
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">জাকারিয়ার তাসফীর</label>
            <div class="col-sm-10">
                <textarea type="text" name="jakariya_tafsir" class="form-control" placeholder="জাকারিয়ার তাসফীর" required>{{ $tafsir->jakariya_tafsir }}</textarea>
            </div>
        </div>

        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">মাজিদ হেডিং</label>
            <div class="col-sm-10">
                <input type="text" name="majid_heading" class="form-control" placeholder="মাজিদ হেডিং" required value="{{ $tafsir->majid_heading }}">
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">মাজিদ তাসফীর</label>
            <div class="col-sm-10">
                <textarea type="text" name="majid_tafsir" class="form-control" placeholder="মাজিদ তাসফীর" required>{{ $tafsir->majid_tafsir }}</textarea>
            </div>
        </div>

        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">আহসানুল হেডিং</label>
            <div class="col-sm-10">
                <input type="text" name="ahsanul_heading" class="form-control" placeholder="আহসানুল হেডিং" required value="{{ $tafsir->ahsanul_heading }}">
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">আহসানুল তাসফীর</label>
            <div class="col-sm-10">
                <textarea type="text" name="ahsanul_tafsir" class="form-control" placeholder="আহসানুল তাসফীর" required>{{ $tafsir->ahsanul_tafsir }}</textarea>
            </div>
        </div>

        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">কাসির হেডিং</label>
            <div class="col-sm-10">
                <input type="text" name="kasir_heading" class="form-control" placeholder="কাসির হেডিং" required value="{{ $tafsir->kasir_heading }}">
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">কাসির তাসফীর</label>
            <div class="col-sm-10">
                <textarea type="text" name="kasir_tafsir" class="form-control" placeholder="কাসির তাসফীর" required>{{ $tafsir->kasir_tafsir }}</textarea>
            </div>
        </div>

        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">অন্য আন্য হেডিং</label>
            <div class="col-sm-10">
                <input type="text" name="other_heading" class="form-control" placeholder="অন্য আন্য হেডিং" required value="{{ $tafsir->other_heading }}">
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">অন্য আন্য তাসফীর</label>
            <div class="col-sm-10">
                <textarea type="text" name="other_tafsir" class="form-control" placeholder="অন্য আন্য তাসফীর" required>{{ $tafsir->other_tafsir }}</textarea>
            </div>
        </div>
        <div class="form-group  row">
            <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Status</label>
            <div class="col-sm-4 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckDefault"
                        {{ $tafsir->status == 1 ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a type="button" class="modal__btn_space" data-bs-dismiss="modal">Close</a>
        <button type="submit" id="editUserBtn" class="btn btn-primary" data-check-area="modal-body">Update</button>
    </div>
</form>
