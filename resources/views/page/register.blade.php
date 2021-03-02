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
    <h2 class="title-header text-success">Update Record</h2>
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
    <form action="{{ url('/register') }}" method="post">
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
                        <option value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Type of ID <span class="required">*</span></label>
                <select name="categoryid" id="categoryid" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($categoryID as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>ID Number <span class="required">*</span></label>
                <input type="text" name="categoryidnumber" value="" class="form-control" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>PhilHealth ID <span class="required">*</span></label>
                <input type="text" name="philhealthid" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>PWD ID</label>
                <input type="text" name="pwd_id" value="" class="form-control">
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
                    <option>NA</option>
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
            <div class="form-group col-md-3">
                <label>Gender <span class="required">*</span></label>
                <select name="sex" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Female">Female</option>
                    <option value="02_Male">Male</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="birthdate" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>Civil Status <span class="required">*</span></label>
                <select name="civilstatus" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($civil_status as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Contact Number <span class="required">*</span></label>
                <input type="text" name="contact_no" value="" class="form-control" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>Employed <span class="required">*</span></label>
                <select name="employed" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($employment_status as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Profession <span class="required">*</span></label>
                <select name="profession" class="custom-select" required>
                    <option value="">Select Here...</option>
                    @foreach($profession as $row)
                        <?php
                        $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                        $str = "$_id $row->name";
                        $value = str_replace(" ", "_", $str)
                        ?>
                        <option value="{{ $value }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h4 class="title-header text-danger mt-5">Address <small class="text-muted text-italic">(Refer to Template for Address Coding)</small></h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Region <span class="required">*</span></label>
                <input type="text" name="region" value="CentralVisayas" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
                <label>Province <span class="required">*</span></label>
                <input type="text" name="province" value="_0722_CEBU" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
                <label>Municipality/City <span class="required">*</span></label>
                <input type="text" name="muncity" value="" class="form-control" required>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-4">
                <label>Barangay <span class="required">*</span></label>
                <input type="text" name="barangay" value="" class="form-control" required>
            </div>
            <div class="form-group col-md-8">
                <label>Unit/Building/House#/Street Name <span class="required">*</span></label>
                <input type="text" name="full_address" value="" class="form-control" required>
            </div>
        </div>


        <h4 class="title-header text-danger mt-5">Employer</h4>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Employer Name <span class="required">*</span></label>
                <input type="text" name="employer_name" value="Cebu South Medical Center" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Employer Address <span class="required">*</span></label>
                <input type="text" name="employer_address" value="San Isidro, City of Talisay, Cebu" class="form-control" readonly>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>LGU <span class="required">*</span></label>
                <input type="text" name="employer_lgu" value="722 - CEBU" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Contact No. <span class="required">*</span></label>
                <input type="text" name="employer_contact_no" value="(032) 273-3226" class="form-control" readonly>
            </div>
        </div>

        <h4 class="title-header text-danger mt-5">Medical Conditions</h4>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Pregnant Status <span class="required">*</span></label>
                <select name="preg_status" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Pregnant">Pregnant</option>
                    <option value="02_Not_Pregnant">Not Pregnant</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>With Allergy <span class="required">*</span></label>
                <select name="with_allergy" id="with_allergy" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>With Comorbidities <span class="required">*</span></label>
                <select name="w_comorbidities" id="with_comorbidity" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Yes">Yes</option>
                    <option value="02_None">No</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>COVID History <span class="required">*</span></label>
                <select name="covid_history" id="was_diagnosed" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Yes">Yes</option>
                    <option value="02_No">No</option>
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-md-6">
                <label>Directly in Interaction with COVID Patient <span class="required">*</span></label>
                <select name="direct_covid" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Yes">Yes</option>
                    <option value="02_No">No</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Provided Electronic Informed Consent <span class="required">*</span></label>
                <select name="consent" class="custom-select" required>
                    <option value="">Select Here...</option>
                    <option value="01_Yes">Yes</option>
                    <option value="02_No">No</option>
                    <option value="03_Unknown">Unknown</option>
                </select>
            </div>
        </div>

        <div id="section_allergy" class="hidden">
            <h4 class="title-header text-danger mt-5">Allergy</h4>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Drug</label>
                    <select name="allergy_01" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Food</label>
                    <select name="allergy_02" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Insect</label>
                    <select name="allergy_03" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Latex</label>
                    <select name="allergy_04" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="form-group col-md-3">
                    <label>Mold</label>
                    <select name="allergy_05" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Pet</label>
                    <select name="allergy_06" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Pollen</label>
                    <select name="allergy_07" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="section_comorbidity" class="hidden">
            <h4 class="title-header text-danger mt-5">Comorbidities</h4>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Hypertension</label>
                    <select name="comorbidity_01" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Heart Disease</label>
                    <select name="comorbidity_02" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Kidney Disease</label>
                    <select name="comorbidity_03" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Diabetes Mellitus</label>
                    <select name="comorbidity_04" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="form-group col-md-3">
                    <label>Brochial Asthma</label>
                    <select name="comorbidity_05" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Immunodefiency State</label>
                    <select name="comorbidity_06" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Cancer</label>
                    <select name="comorbidity_07" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Others</label>
                    <select name="comorbidity_08" class="custom-select">
                        <option value="">Select Here...</option>
                        <option value="01_Yes">Yes</option>
                        <option value="02_No" selected>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="section_covidHistory" class="hidden">
            <h4 class="title-header text-danger mt-5">COVID History</h4>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Date of First Positive Result/Specimen Collection</label>
                    <input type="date" name="covid_date" value="" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Classification of COVID19</label>
                    <select name="covid_classification" class="custom-select">
                        <option value="NA">Select Here...</option>
                        @foreach($classification as $row)
                            <?php
                            $_id = str_pad($row->id,2,"0",STR_PAD_LEFT);
                            $str = "$_id $row->name";
                            $value = str_replace(" ", "_", $str)
                            ?>
                            <option value="{{ $value }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <button class="btn btn-success btn-lg" type="submit">
            <i class="fa fa-send"></i> Update Record
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
@endsection
