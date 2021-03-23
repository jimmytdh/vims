@extends('app')
@section('title','Registration (Sinovac Vaccination)')
@section('css')
    <style>
        . { color:red; }
        label {
            font-weight: normal;
            color: grey;
        }
    </style>
@endsection
@section('content')
    <h2 class="title-header text-success">EDIT VACCINEE</h2>

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

    <form action="{{ url('/list/vas/update/'.$id) }}" method="post">
        {{ csrf_field() }}
        <h4 class="title-header text-danger">Category</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Category</label>
                <select name="category" id="category" class="custom-select" >
                    <option value="">Select Here...</option>
                    @foreach($category as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option @if($data->category == $value) selected @endif value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Type of ID</label>
                <select name="category_id" id="category_id" class="custom-select" >
                    <option value="">Select Here...</option>
                    @foreach($categoryID as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option @if($data->category_id == $value) selected @endif value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>ID Number</label>
                <input type="text" name="category_id_number" value="{{ $data->category_id_number }}" class="form-control" >
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-4">
                <label>Facility</label>
                <select name="facility" class="custom-select" >
                    <option value="">Select...</option>
                    <?php $facilities = \App\Models\Facility::orderBy('name','asc')->get(); ?>
                    @foreach($facilities as $facility)
                        <option @if($facility->name == $data->facility) selected @endif>{{ $facility->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>PhilHealth ID</label>
                <input type="text" name="philhealth_id" value="{{ $data->philhealth_id }}" class="form-control" >
            </div>
            <div class="form-group col-md-4">
                <label>PWD ID</label>
                <input type="text" name="pwd_id" value="{{ $data->pwd_id }}" class="form-control">
            </div>
        </div>


        <h4 class="title-header text-danger mt-5">Basic Information</h4>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>First Name</label>
                <input type="text" name="firstname" value="{{ $data->firstname }}" class="form-control" >
            </div>
            <div class="form-group col-md-3">
                <label>Middle Name</label>
                <input type="text" name="middlename" value="{{ $data->middlename }}" class="form-control" >
            </div>
            <div class="form-group col-md-3">
                <label>Last Name</label>
                <input type="text" name="lastname" value="{{ $data->lastname }}" class="form-control" >
            </div>
            <div class="form-group col-md-3">
                <label>Extension Name</label>
                <select name="suffix" class="custom-select" >
                    <option value="">Select Here...</option>
                    <option selected>NA</option>
                    <option @if($data->suffix=='SR') selected @endif>SR</option>
                    <option @if($data->suffix=='JR') selected @endif>JR</option>
                    <option @if($data->suffix=='I') selected @endif>I</option>
                    <option @if($data->suffix=='II') selected @endif>II</option>
                    <option @if($data->suffix=='III') selected @endif>III</option>
                    <option @if($data->suffix=='III') selected @endif>III</option>
                    <option @if($data->suffix=='IV') selected @endif>IV</option>
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-4">
                <label>Gender</label>
                <select name="sex" class="custom-select" >
                    <option value="">Select Here...</option>
                    <option @if($data->sex=='01_Female') selected @endif value="01_Female">Female</option>
                    <option @if($data->sex=='02_Male') selected @endif value="02_Male">Male</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Date of Birth</label>
                <input type="date" name="birthdate" value="{{ $data->birthdate }}" class="form-control" >
            </div>
            <div class="form-group col-md-4">
                <label>Contact Number</label>
                <input type="text" name="contact_no" value="{{ $data->contact_no }}" class="form-control" >
            </div>
        </div>

        <h4 class="title-header text-danger mt-5">Address</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Region</label>
                <select name="region" id="address_region" class="custom-select" >
                    <option value="">Select Here...</option>
                    @foreach($region as $row)
                        <option {{ ($row->vimsCode==$data->region) ? 'selected':'' }} value="{{ $row->vimsCode }}">{{ $row->regDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Province</label>
                <select name="province" id="address_province" class="custom-select" >
                    <option value="">Select Here...</option>
                    @foreach($provinces as $row)
                        <option {{ ($row->vimsCode==$data->province) ? 'selected':'' }} value="{{ $row->vimsCode }}">{{ $row->provDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Municipality/City</label>
                <select name="muncity" id="address_muncity" class="custom-select" >
                    <option value="">Select Here...</option>
                    @foreach($muncity as $row)
                        <option @if($data->muncity == $row->vimsCode) selected @endif value="{{ $row->vimsCode }}">{{ $row->citymunDesc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>Barangay</label>
                <select name="brgy" id="address_brgy" class="custom-select" >
                    <option value="">Select Here...</option>
                    @foreach($brgy as $row)
                        <option @if($data->brgy == $row->vimsCode) selected @endif value="{{ $row->vimsCode }}">{{ $row->brgyDesc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Unit/Building/House#/Street Name</label>
                <input type="text" name="street_name" value="{{ $data->street_name }}" class="form-control" >
            </div>
        </div>
        <hr>
        <button name="btnUpdate" value="true" class="btn btn-success btn-lg btn-block" type="submit">
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
