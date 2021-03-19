<form action="{{ url('/vas/vaccination/'.$id) }}" method="post" id="vaccinationForm">
    <div class="form-group">
        <label>Consent</label>
        <select name="consent" class="custom-select consent">
            <option value="">Select...</option>
            <option {{ ($data->consent=='01_Yes') ? 'selected':'' }} value="01_Yes">Yes</option>
            <option {{ ($data->consent=='02_No') ? 'selected':'' }} value="02_No">No</option>
        </select>
    </div>
    <div class="form-group refusal_reason {{ ($data->consent=='01_Yes') ? 'hidden' : '' }}">
        <label>Reason for Refusal</label>
        <select name="refusal_reason" class="custom-select">
            <option value="">Select...</option>
            @foreach($refusal as $row)
                <option {{ ($data->refusal_reason==$row->name) ? 'selected':'' }}>{{ $row->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="consent_content {{ ($data->consent=='02_No') ? 'hidden' : '' }}">
        <div class="form-group">
            <label>Vaccination Date</label>
            <input type="date" class="form-control" name="vaccination_date" value="{{ $data->vaccination_date }}" readonly>
        </div>
        <div class="form-group">
            <label>Vaccine Manufacturer Name</label>
            <select name="vaccine_manufacturer" class="custom-select consent">
                <option value="">Select...</option>
                <option {{ ($data->vaccine_manufacturer=='Astrazeneca') ? 'selected':'' }}>Astrazeneca</option>
                <option {{ ($data->vaccine_manufacturer=='Sinovac') ? 'selected':'' }}>Sinovac</option>
            </select>
        </div>
        <div class="form-group">
            <label>Batch Number</label>
            <input type="text" class="form-control" name="batch_no" value="{{ $data->batch_no }}">
        </div>
        <div class="form-group">
            <label>Lot Number</label>
            <input type="text" class="form-control" name="lot_no" value="{{ $data->lot_no }}">
        </div>
        <div class="form-group">
            <label>Vaccinator</label>
            <select name="vaccinator" class="custom-select">
                <option value="">Select...</option>
                @foreach($vaccinator as $vac)
                <option value="{{ $vac->id }}" {{ ($data->vaccinator_name==$vac->name) ? 'selected':'' }}>{{ $vac->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Dose</label>
            <select name="dose" class="custom-select">
                <option value="">Select...</option>
                <option {{ ($dose==0) ? 'selected':'' }} value="dose1">1st Dose</option>
                <option {{ ($dose>0) ? 'selected':'' }} value="dose2">2nd Dose</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-sm-6">
            <button type="submit" class="btn btn-block btn-success">Submit</button>
        </div>
        <div class="form-group col-sm-6">
            <button type="button" data-dismiss="modal" class="btn btn-block btn-default">Close</button>
        </div>
    </div>
</form>
