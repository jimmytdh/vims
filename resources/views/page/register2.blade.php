@extends('app')

@section('css')
    <style>
        .required { color:red; }
        label {
            font-weight: normal;
            color: grey;
        }
    </style>
@endsection
@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            Successfully submitted! if you want to change the information submitted, please contact System Administrator. Thank you!
        </div>
    @endif
    @if(session('duplicate'))
        <div class="alert alert-danger">
            <i class="fa fa-exclamation"></i>
            Oppps! Record already exists in the database. Please contact System Administrator to fix this problem. Thank you!
        </div>
    @endif
    <form action="{{ url('/register') }}" method="post">
        {{ csrf_field() }}
        <h2 class="title-header text-muted">Category</h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Category <span class="required">*</span></label>
                <select name="category" id="category" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($category as $row)
                        <option {{ ($row->id==1) ? 'selected':'' }} value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Type of ID <span class="required">*</span></label>
                <select name="category_id" id="category_id" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($categoryID as $row)
                        <option {{ ($row->id==3) ? 'selected':'' }} value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>ID Number <span class="required">*</span></label>
                <input type="text" class="form-control" name="category_id_number" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>PhilHealth ID <span class="required">*</span></label>
                <input type="text" class="form-control" name="philhealth_no" required>
            </div>
            <div class="form-group col-md-6">
                <label>PWD ID</label>
                <input type="text" class="form-control" value="NA" name="pwd_id">
            </div>
        </div>


        <h2 class="title-header text-muted mt-5">Basic Information</h2>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>First Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="fname" required>
            </div>
            <div class="form-group col-md-3">
                <label>Middle Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="mname" required>
            </div>
            <div class="form-group col-md-3">
                <label>Last Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="lname" required>
            </div>
            <div class="form-group col-md-3">
                <label>Extension Name</label>
                <input type="text" class="form-control" value="NA" name="suffix" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-3">
                <label>Gender <span class="required">*</span></label>
                <select name="sex" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" class="form-control" name="dob" required>
            </div>
            <div class="form-group col-md-3">
                <label>Civil Status <span class="required">*</span></label>
                <select name="civil_status" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($civil_status as $row)
                        <option {{ ($row->id==1) ? 'selected':'' }} value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Contact Number <span class="required">*</span></label>
                <input type="text" class="form-control" name="contact_no" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>Employed <span class="required">*</span></label>
                <select name="employment_status" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($employment_status as $row)
                        <option {{ ($row->id==1) ? 'selected':'' }} value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Profession <span class="required">*</span></label>
                <select name="profession" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($profession as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h2 class="title-header text-muted mt-5">Address</h2>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Region <span class="required">*</span></label>
                <select name="address_region" id="address_region" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($region as $row)
                        <option {{ ($row->regCode=='07') ? 'selected':'' }} value="{{ $row->regCode }}">{{ $row->regDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Province <span class="required">*</span></label>
                <select name="address_province" id="address_province" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($provinces as $row)
                        <option {{ ($row->provCode=='0722') ? 'selected':'' }} value="{{ $row->provCode }}">{{ $row->provDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Municipality/City <span class="required">*</span></label>
                <select name="address_muncity" id="address_muncity" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($muncity as $row)
                        <option value="{{ $row->citymunCode }}">{{ $row->citymunDesc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-4">
                <label>Barangay <span class="required">*</span></label>
                <select name="address_brgy" id="address_brgy" class="custom-select" required>
                    <option value="">Select Here...</option>
                </select>
            </div>
            <div class="form-group col-md-8">
                <label>Unit/Building/House#/Street Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="address_street" required>
            </div>
        </div>


        <h2 class="title-header text-muted mt-5">Employer</h2>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Employer Name <span class="required">*</span></label>
                <input type="text" class="form-control" value="Cebu South Medical Center" name="employer" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Employer Address <span class="required">*</span></label>
                <input type="text" class="form-control" value="San Isidro, Talisay City, Cebu" name="employer_address" readonly>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>LGU <span class="required">*</span></label>
                <input type="text" class="form-control" value="Talisay City" name="employer_province" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Contact No. <span class="required">*</span></label>
                <input type="text" class="form-control" value="(032) 273-3226" name="employer_contact" readonly>
            </div>
        </div>

        <h2 class="title-header text-muted mt-5">Medical Conditions</h2>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Pregnant Status <span class="required">*</span></label>
                <select name="pregnant_status" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Pregnant</option>
                    <option selected>Not Pregnant</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>With Allergy <span class="required">*</span></label>
                <select name="with_allergy" id="with_allergy" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Yes</option>
                    <option selected>No</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>With Comorbidities <span class="required">*</span></label>
                <select name="with_comorbidity" id="with_comorbidity" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Yes</option>
                    <option selected>No</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>COVID History <span class="required">*</span></label>
                <select name="was_diagnosed" id="was_diagnosed" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Yes</option>
                    <option selected>No</option>
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>Directly in Interaction with COVID Patient <span class="required">*</span></label>
                <select name="direct_interaction" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Yes</option>
                    <option selected>No</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Provided Electronic Informed Consent <span class="required">*</span></label>
                <select name="willing_to_vaccinated" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option selected>Yes</option>
                    <option>No</option>
                    <option>Unknown</option>
                </select>
            </div>
        </div>

        <div id="section_allergy" class="hidden">
            <h2 class="title-header text-muted mt-5">Allergy</h2>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Drug</label>
                    <select name="drug" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Food</label>
                    <select name="food" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Insect</label>
                    <select name="insect" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Latex</label>
                    <select name="latex" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="form-group col-md-3">
                    <label>Mold</label>
                    <select name="mold" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Pet</label>
                    <select name="pet" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Pollen</label>
                    <select name="pollen" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="section_comorbidity" class="hidden">
            <h2 class="title-header text-muted mt-5">Comorbidities</h2>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Hypertension</label>
                    <select name="hypertension" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Heart Disease</label>
                    <select name="heart_disease" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Kidney Disease</label>
                    <select name="kidney_disease" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Diabetes Mellitus</label>
                    <select name="diabetes" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="form-group col-md-3">
                    <label>Brochial Asthma</label>
                    <select name="asthma" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Immunodefiency State</label>
                    <select name="immunodefiency" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Cancer</label>
                    <select name="cancer" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Others</label>
                    <select name="others" class="custom-select">
                        <option value="">Select Here...</option>
                        <option>Yes</option>
                        <option selected>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="section_covidHistory" class="hidden">
            <h2 class="title-header text-muted mt-5">COVID History</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Date of First Positive Result/Specimen Collection</label>
                    <input type="date" name="date_result" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Classification of COVID19</label>
                    <select name="classification" class="custom-select">
                        <option value="">Select Here...</option>
                        @foreach($classification as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <button class="btn btn-success btn-lg" type="submit">
            <i class="fa fa-send"></i> Submit Record
        </button>
    </form>

@endsection

@section('js')
    <script>
        $("#with_allergy").on('change',function (){
            var ans = $(this).val();
            if(ans==='Yes'){
                $("#section_allergy").removeClass('hidden');
            }else{
                $("#section_allergy").addClass('hidden');
            }
        });

        $("#with_comorbidity").on('change',function (){
            var ans = $(this).val();
            if(ans==='Yes'){
                $("#section_comorbidity").removeClass('hidden');
            }else{
                $("#section_comorbidity").addClass('hidden');
            }
        });

        $("#was_diagnosed").on('change',function (){
            var ans = $(this).val();
            if(ans==='Yes'){
                $("#section_covidHistory").removeClass('hidden');
            }else{
                $("#section_covidHistory").addClass('hidden');
            }
        });
    </script>

    <script>
        $("#address_region").on('change',function(){
            var code = $(this).val();
            showProvince(code);
        });

        $("#address_province").on('change',function(){
            var code = $(this).val();
            showMuncity(code);
        });

        $("#address_muncity").on('change',function(){
            var code = $(this).val();
            showBrgy(code);
        });

        function showProvince(regCode)
        {
            selectEmpty('address_province');
            selectEmpty('address_muncity');
            selectEmpty('address_brgy');
            var url = "{{ url('/provinces/') }}/"+regCode;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    jQuery.each( data, function( i, val ) {
                        $("#address_province").append($('<option>', {
                            value: val.provCode,
                            text: val.provDesc
                        }));
                    });
                }
            });
        }

        function showMuncity(provCode)
        {
            selectEmpty('address_muncity');
            selectEmpty('address_brgy');
            var url = "{{ url('/muncity/') }}/"+provCode;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    jQuery.each( data, function( i, val ) {
                        $("#address_muncity").append($('<option>', {
                            value: val.citymunCode,
                            text: val.citymunDesc
                        }));
                    });
                }
            });
        }

        function showBrgy(citymunCode)
        {
            selectEmpty('address_brgy');
            var url = "{{ url('/barangay/') }}/"+citymunCode;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    jQuery.each( data, function( i, val ) {
                        $("#address_brgy").append($('<option>', {
                            value: val.brgyCode,
                            text: val.brgyDesc
                        }));
                    });
                }
            });
        }
        function selectEmpty(name)
        {
            $("#"+name).empty().append($('<option>', {
                value: "",
                text: 'Select Here...'
            }));
        }
    </script>
@endsection
