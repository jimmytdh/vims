@extends('app')
@section('title','Registration (Sinovac Vaccination)')
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
    <h2 class="title-header text-success">Registration</h2>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            Successfully updated!
        </div>
    @endif
    @if(session('duplicate'))
        <div class="alert alert-info">
            <i class="fa fa-exclamation-circle"></i>
            Your data was successfully updated!
        </div>
    @endif

    @if(session('saved'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i>
            Your data was successfully saved!
        </div>
    @endif

    <form action="{{ url('/register/vas') }}" method="post">
        {{ csrf_field() }}
        <h4 class="title-header text-danger">Category</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Category <span class="required">*</span></label>
                <select name="category" id="category" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($category as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option {{ ($value=='01_Health_Care_Worker') ? 'selected':'' }} value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Type of ID <span class="required">*</span></label>
                <select name="category_id" id="category_id" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($categoryID as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option {{ ($value=='03_Facility_ID_number') ? 'selected':'' }} value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>ID Number <span class="required">*</span></label>
                <input type="text" name="category_id_number" value="" class="form-control" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-4">
                <label>Facility <span class="required">*</span></label>
                <select name="facility" class="custom-select" required>
                    <option value="">Select...</option>
                    <?php $facilities = \App\Models\Facility::orderBy('name','asc')->get(); ?>
                    @foreach($facilities as $facility)
                        <option>{{ $facility->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>PhilHealth ID <span class="required">*</span></label>
                <input type="text" name="philhealth_id" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label>PWD ID</label>
                <input type="text" name="pwd_id" value="NA" class="form-control">
            </div>
        </div>


        <h4 class="title-header text-danger mt-5">Basic Information</h4>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>First Name <span class="required">*</span></label>
                <input type="text" name="firstname" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Middle Name <span class="required">*</span></label>
                <input type="text" name="middlename" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Last Name <span class="required">*</span></label>
                <input type="text" name="lastname" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Extension Name</label>
                <select name="suffix" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option selected>NA</option>
                    <option>SR</option>
                    <option>JR</option>
                    <option>I</option>
                    <option>II</option>
                    <option>III</option>
                    <option>III</option>
                    <option>IV</option>
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-4">
                <label>Gender <span class="required">*</span></label>
                <select name="sex" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Female">Female</option>
                    <option value="02_Male">Male</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="birthdate" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label>Contact Number <span class="required">*</span></label>
                <input type="text" name="contact_no" value="" class="form-control" required>
            </div>
        </div>

        <h4 class="title-header text-danger mt-5">Address</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Region <span class="required">*</span></label>
                <select name="region" id="address_region" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($region as $row)
                        <option {{ ($row->vimsCode=='CentralVisayas') ? 'selected':'' }} value="{{ $row->vimsCode }}">{{ $row->regDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Province <span class="required">*</span></label>
                <select name="province" id="address_province" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($provinces as $row)
                        <option {{ ($row->vimsCode=='_0722_CEBU') ? 'selected':'' }} value="{{ $row->vimsCode }}">{{ $row->provDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Municipality/City <span class="required">*</span></label>
                <select name="muncity" id="address_muncity" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($muncity as $row)
                        <option value="{{ $row->vimsCode }}">{{ $row->citymunDesc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>Barangay <span class="required">*</span></label>
                <select name="brgy" id="address_brgy" class="custom-select" required>
                    <option value="">Select Here...</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Unit/Building/House#/Street Name <span class="required">*</span></label>
                <input type="text" name="street_name" value="" class="form-control" required>
            </div>
        </div>

        <h4 class="title-header text-danger mt-5">Date of Vaccination</h4>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Select Date <span class="required">*</span></label>
                <input type="date" name="vaccination_date" value="{{ date('Y-m-d') }}" class="form-control" required>
            </div>
        </div>
        <hr>
        <button class="btn btn-success btn-lg btn-block" type="submit">
            <i class="fa fa-send"></i> Submit Data
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
            if(ans==='01_Yes'){
                $("#section_comorbidity").removeClass('hidden');
            }else{
                $("#section_comorbidity").addClass('hidden');
            }
        });

        $("#was_diagnosed").on('change',function (){
            var ans = $(this).val();
            if(ans==='01_Yes'){
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
            console.log(code);
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
                            value: val.vimsCode,
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
                            value: val.vimsCode,
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
                            value: val.vimsCode,
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
