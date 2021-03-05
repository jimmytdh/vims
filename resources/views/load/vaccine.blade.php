<form action="{{ url('/vaccine') }}" method="post" id="vaccineForm">
    <input type="hidden" name="emp_id" value="{{ $id }}">
    <div class="form-group">
        <label>Vaccine Manufacturer</label>
        <input type="text" class="form-control" name="type" value="{{ $data->type }}">
    </div>
    <hr style="height:1px;
            border:none;
            color:#bfbfbf;
            background-color:#bfbfbf;">
    <div class="form-row">
        <div class="form-group col-sm-6">
            <label>1st Dosage</label>
            <input type="date" class="form-control" name="date_1" value="{{ $data->date_1 }}">
        </div>
        <div class="form-group col-sm-6">
            <label>Lot #</label>
            <input type="text" class="form-control" name="lot_1" value="{{ $data->lot_1 }}">
        </div>
    </div>
    <div class="form-group">
        <label>Vaccinator</label>
        <input type="text" class="form-control" name="vaccinator_1" value="{{ $data->vaccinator_1 }}">
    </div>

    <hr style="height:2px;
            border:none;
            color:#bfbfbf;
            background-color:#bfbfbf;">
    <div class="form-row">
        <div class="form-group col-sm-6">
            <label>2nd Dosage</label>
            <input type="date" class="form-control" name="date_2" value="{{ $data->date_2 }}">
        </div>
        <div class="form-group col-sm-6">
            <label>Lot #</label>
            <input type="text" class="form-control" name="lot_2" value="{{ $data->lot_2 }}">
        </div>
    </div>
    <div class="form-group">
        <label>Vaccinator</label>
        <input type="text" class="form-control" name="vaccinator_2" value="{{ $data->vaccinator_2 }}">
    </div>
    <div class="form-row">
        <button type="submit" class="btn btn-success btn-lg btn-block">
            <i class="fa fa-save"></i> Submit
        </button>
    </div>
</form>

