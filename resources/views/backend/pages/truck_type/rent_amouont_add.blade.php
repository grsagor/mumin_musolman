<div class="form-group row" data-no="{{ $num }}" data-parent="{{ $containerClass }}">
    <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Rent amount</label>
    <div class="col-sm-10 d-flex gap-2">
        <input type="text" name="load_type[]" class="form-control" placeholder="Load type" required>
        <input type="number" name="rent_amount[]" class="form-control" placeholder="Rent amount" required>
        <button type="button" class="btn text-error-700 bg-error-50 remove_row"><i class="fa-solid fa-x"></i></button>
    </div>
</div>
