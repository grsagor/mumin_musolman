@if ($value == 'load')
    <div class="form-group row" data-no="1" data-total="1" data-parent="{{ $containerClass }}">
        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Rent amount</label>
        <div class="col-sm-10 d-flex gap-2">
            <input type="text" name="load_type[]" class="form-control" placeholder="Load type" required>
            <input type="number" name="rent_amount[]" class="form-control" placeholder="Rent amount" required>
            <button type="button" class="btn text-primary bg-secondary increment_row"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
@else
    <div class="form-group row">
        <label for="" class="text-gray-700 fw-medium col-sm-2 col-form-label">Rent amount</label>
        <div class="col-sm-10">
            <input type="number" name="rent_amount[]" class="form-control" placeholder="Rent amount" required>
        </div>
    </div>
@endif
