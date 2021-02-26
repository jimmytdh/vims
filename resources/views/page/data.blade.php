@extends('app')
@section('title','My Data')
@section('css')
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <style>
        p {
            text-align: justify;
            font-size: 1.2em;
            color: #000;
        }
        .table-user tr td {
            text-align: center;
            padding: 15px !important;
            width: 20%;
        }
        small.label {
            border-top: 1px solid #3a7915;
            display: block;
            color: #333333 !important;
            font-size: 0.7em;
            color: #3a7915 !important;
            font-weight: bold;
        }

        .table-allergy tr td:first-child {
            text-align: left;
            font-weight: bold;
            color: #3a7915 !important;
        }.table-allergy tr td {
            padding: 5px !important;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    @if($data)
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">My Personal Information</h3>
        </div>
        <div class="box-body">
           <table class="table table-striped table-hover table-sm table-user">
               <tr>
                   <td>
                       <a href="#" class="user" title="Last Name" id="lname" data-pk="{{ $user->id }}">{{ $user->lname }}</a>
                       <small class="label">Last Name</small>
                   </td>
                   <td>
                       <a href="#" class="user" title="First Name" id="fname" data-pk="{{ $user->id }}">{{ $user->fname }}</a>
                       <small class="label">First Name</small>
                   </td>
                   <td>
                       <a href="#" class="user" title="Middle Name" id="mname" data-pk="{{ $user->id }}">{{ $user->mname }}</a>
                       <small class="label">Middle Name</small>
                   </td>
                   <td>
                       <a href="#" title="Suffix" id="suffix" data-type="select" data-value="{{ $personal->suffix }}" data-pk="{{ $personal->id }}">{{ $personal->suffix }}</a>
                       <small class="label">Suffix</small>
                   </td>
                   <td>
                       <a href="#" class="personal" title="Contact No." id="contact_no" data-pk="{{ $personal->id }}">{{ $personal->contact_no }}</a>
                       <small class="label">Contact Number</small>
                   </td>
               </tr>

               <tr>
                   <td>
                       <a href="#" title="Sex" id="sex" data-type="select" data-value="{{ $personal->sex }}" data-pk="{{ $personal->id }}">{{ $personal->sex }}</a>
                       <small class="label">Sex</small>
                   </td>
                   <td>
                       <a href="#" id="dob" data-value="{{ $personal->dob }}" data-type="date" data-pk="{{ $personal->id }}" data-title="Date of Birth">{{ date('M d, Y',strtotime($personal->dob)) }}</a>
                       <small class="label">Date of Birth</small>
                   </td>
                   <td>
                       <a href="#" title="Civil Status" id="civil_status" data-value="{{ $personal->civil_status }}" data-type="select" data-pk="{{ $personal->id }}">{{ optional(\App\Models\CivilStatus::find($personal->civil_status))->name }}</a>
                       <small class="label">Civil Status</small>
                   </td>
                   <td>
                       <a href="#" title="Employment Status" id="employment_status" data-value="{{ $data->employment_status }}" data-type="select" data-pk="{{ $data->id }}">{{ optional(\App\Models\EmploymentStatus::find($data->employment_status))->name }}</a>
                       <small class="label">Employment Status</small>
                   </td>
                   <td>
                       <a href="#" title="Directly in Interaction with COVID Patient" id="direct_interaction" class="dataSelect" data-value="{{ $data->direct_interaction }}" data-type="select" data-pk="{{ $data->id }}">{{ optional(\App\Models\Confirmation::find($data->direct_interaction))->name }}</a>
                       <small class="label">Directly in Interaction with COVID Patient</small>
                   </td>
               </tr>

               <tr>
                   <td>
                       <a href="#" title="Category" id="category" data-value="{{ $data->category }}" data-type="select" data-pk="{{ $data->id }}">{{ optional(\App\Models\Categories::find($data->category))->name }}</a>
                       <small class="label">Category</small>
                   </td>
                   <td>
                       <a href="#" title="Category ID" id="category_id" data-value="{{ $data->category_id }}" data-type="select" data-pk="{{ $data->id }}">{{ optional(\App\Models\CategoryID::find($data->category_id))->name }}</a>
                       <small class="label">Category ID</small>
                   </td>
                   <td>
                       <a href="#" class="dataEdit" title="Category ID Number" id="category_id_number" data-pk="{{ $data->id }}">{{ $data->category_id_number }}</a>
                       <small class="label">Category ID Number</small>
                   </td>
                   <td>
                       <a href="#" class="personal" title="PhilHealth ID" id="philhealth_id" data-pk="{{ $personal->id }}">{{ $personal->philhealth_id }}</a>
                       <small class="label">PhilHealth ID</small>
                   </td>
                   <td>
                       <a href="#" class="dataEdit" title="PWD ID" id="pwd_id" data-pk="{{ $data->id }}">{{ $data->pwd_id }}</a>
                       <small class="label">PWD ID</small>
                   </td>
               </tr>

               <tr>
                   <td>
                       <a href="#" title="Profession" id="profession" data-value="{{ $data->profession }}" data-type="select" data-pk="{{ $data->id }}">{{ optional(\App\Models\Profession::find($data->profession))->name }}</a>
                       <small class="label">Profession</small>
                   </td>
                   <td>
                       {{ $data->employer }}
                       <small class="label">Name of Employer</small>
                   </td>
                   <td>
                       {{ $data->employer_province }}
                       <small class="label">Province/HUC/ICC of Employer</small>
                   </td>
                   <td>
                       {{ $data->employer_address }}
                       <small class="label">Address of Employer</small>
                   </td>
                   <td>
                       {{ $data->employer_contact }}
                       <small class="label">Contact Number of Employer</small>
                   </td>
               </tr>
           </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Pregnancy Status and Allergies</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover table-sm table-allergy">
                <thead>
                    <tr>
                        <th></th>
                        <th width="20%" class="text-center">Yes</th>
                        <th width="20%" class="text-center">No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pregnancy Status</td>
                        <td><input type="radio" name="pregnancy_status" data-table="user_info" value="Pregnant" {{ ($data->pregnancy_status=='Pregnant') ? 'checked':'' }}></td>
                        <td><input type="radio" name="pregnancy_status" data-table="user_info" value="Not Pregnant" {{ ($data->pregnancy_status=='Not Pregnant') ? 'checked':'' }}></td>
                    </tr>
                    <tr>
                        <td>Drug Allergy</td>
                        <td><input type="radio" name="drug" value="Yes"></td>
                        <td><input type="radio" name="drug" value="No"></td>
                    </tr>
                    <tr>
                        <td>Food Allergy</td>
                        <td><input type="radio" name="food" value="Yes"></td>
                        <td><input type="radio" name="food" value="No"></td>
                    </tr>
                    <tr>
                        <td>Insect Allergy</td>
                        <td><input type="radio" name="insect" value="Yes"></td>
                        <td><input type="radio" name="insect" value="No"></td>
                    </tr>
                    <tr>
                        <td>Latex Allergy</td>
                        <td><input type="radio" name="latex" value="Yes"></td>
                        <td><input type="radio" name="latex" value="No"></td>
                    </tr>
                    <tr>
                        <td>Mold Allergy</td>
                        <td><input type="radio" name="mold" value="Yes"></td>
                        <td><input type="radio" name="mold" value="No"></td>
                    </tr>
                    <tr>
                        <td>Pet Allergy</td>
                        <td><input type="radio" name="pet" value="Yes"></td>
                        <td><input type="radio" name="pet" value="No"></td>
                    </tr>
                    <tr>
                        <td>Pollen Allergy</td>
                        <td><input type="radio" name="pollen" value="Yes"></td>
                        <td><input type="radio" name="pollen" value="No"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Comorbidity</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover table-sm table-allergy">
                <thead>
                <tr>
                    <th></th>
                    <th width="20%" class="text-center">Yes</th>
                    <th width="20%" class="text-center">No</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>With Comorbidity</td>
                    <td><input type="radio" name="comorbidity" value="Yes"></td>
                    <td><input type="radio" name="comorbidity" value="No"></td>
                </tr>
                <tr>
                    <td>Hypertension</td>
                    <td><input type="radio" name="hypertension" value="Yes"></td>
                    <td><input type="radio" name="hypertension" value="No"></td>
                </tr>
                <tr>
                    <td>Heart Disease</td>
                    <td><input type="radio" name="heart_disease" value="Yes"></td>
                    <td><input type="radio" name="heart_disease" value="No"></td>
                </tr>
                <tr>
                    <td>Kidney Disease</td>
                    <td><input type="radio" name="kidney_disease" value="Yes"></td>
                    <td><input type="radio" name="kidney_disease" value="No"></td>
                </tr>
                <tr>
                    <td>Diabetes Mellitus</td>
                    <td><input type="radio" name="diabetes" value="Yes"></td>
                    <td><input type="radio" name="diabetes" value="No"></td>
                </tr>
                <tr>
                    <td>Bronchial Asthma</td>
                    <td><input type="radio" name="asthma" value="Yes"></td>
                    <td><input type="radio" name="asthma" value="No"></td>
                </tr>
                <tr>
                    <td>Immunodeficiency</td>
                    <td><input type="radio" name="immunodeficiency" value="Yes"></td>
                    <td><input type="radio" name="immunodeficiency" value="No"></td>
                </tr>
                <tr>
                    <td>Cancer</td>
                    <td><input type="radio" name="cancer" value="Yes"></td>
                    <td><input type="radio" name="cancer" value="No"></td>
                </tr>
                <tr>
                    <td>Others</td>
                    <td><input type="radio" name="others" value="Yes"></td>
                    <td><input type="radio" name="others" value="No"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        Please Specify:
                        <br>
                        <textarea name="others_info" rows="3" style="resize: none" class="form-control"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">COVID History</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover table-sm">
                <tr>
                    <td>
                        No
                        <small class="label">Patient was diagnosed with COVID19?</small>
                    </td>
                    <td>
                        N/A
                        <small class="label">Date of Result/Specimen Collection</small>
                    </td>
                    <td>
                        N/A
                        <small class="label">Classification of COVID19</small>
                    </td>
                </tr>

            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <div class="alert alert-danger">
        <label>
            <input type="checkbox" name="willing_to_vaccinated">
            Willing to be Vaccinated? <small><em>(Put check if YES!)</em></small>
        </label>
    </div>
    @else
        <form action="{{ url('/mydata') }}" method="post" id="formInfo">
            {{ csrf_field() }}
            <div class="alert alert-warning">
                <p class="text-black-50"><strong>Dear Respondent, </strong></p>
                <p class="text-black-50">This is for the Cebu South Medical Vaccine Information Management System - Immunization Registry. All fields are required based on the format supplied by the Department of Health (DOH).</p>
                <p class="text-black-50"><strong>NOTE:</strong> The DOH has not specified which COVID-19 Vaccine Brand this is for. This is for generic information gathering at this point. </p>
                <p class="text-black-50">To ensure the protection and privacy of participants in accordance with the Data Privacy Act of 2012, responses and all information regarding the participant will be treated with utmost confidentiality. The data will be stored in the SERVER of IHOMP under the protection of SOPHOS Firewall. No other copies will be stored elsewhere. The data will be kept for a maximum of five years. </p>
                <hr>
                <p class="text-black-50">
                    <label>
                        <input type="checkbox" value="1" required name="consent">
                        I consent to record my personal information for documentation purposes of this activity.
                    </label>
                    <button class="btn btn-default float-right" type="submit">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </p>

                <div class="clearfix"></div>
            </div>
        </form>
    @endif
@endsection

@section('js')
    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-editable/js/bootstrap-editable.js') }}"></script>
    <script>
        $('.user').editable({
            url: "{{ url('/mydata/update/user') }}",
            type: 'text',
            success: function(data){
                console.log(data);
            }
        });
        $('.personal').editable({
            url: "{{ url('/mydata/update/personal') }}",
            type: 'text',
            success: function(data){
                console.log(data);
            }
        });
        $('#suffix').editable({
            url: "{{ url('/mydata/update/personal') }}",
            source: [
                {value: 'NA', text: 'NA'},
                {value: 'JR', text: 'JR'},
                {value: 'SR', text: 'SR'},
                {value: 'II', text: 'II'},
                {value: 'III', text: 'III'},
                {value: 'IV', text: 'IV'},
                {value: 'V', text: 'V'}
            ]
        });
        $('#sex').editable({
            url: "{{ url('/mydata/update/personal') }}",
            source: [
                {value: 'Male', text: 'Male'},
                {value: 'Female', text: 'Female'}
            ]
        });

        $('#civil_status').editable({
            url: "{{ url('/mydata/update/personal') }}",
            source: [
                @foreach($civil_status as $row)
                    {value: "{{ $row->id }}", text: "{{ $row->name }}"},
                @endforeach
            ]
        });

        $('#dob').editable({
            url: "{{ url('/mydata/update/personal') }}",
            format: 'yyyy-mm-dd',
            viewformat: 'M dd, yyyy',
            datepicker: {
                weekStart: 0
            }
        });

        $('#employment_status').editable({
            url: "{{ url('/mydata/update/data') }}",
            source: [
                @foreach($employment_status as $row)
                    {value: "{{ $row->id }}", text: "{{ $row->name }}"},
                @endforeach
            ]
        });

        $('.dataEdit').editable({
            url: "{{ url('/mydata/update/data') }}",
            type: 'text'
        });
        $('.dataSelect').editable({
            url: "{{ url('/mydata/update/data') }}",
            source: [
                @foreach($confirmation as $row)
                    {value: "{{ $row->id }}", text: "{{ $row->name }}"},
                @endforeach
            ]
        });
        $('#category').editable({
            url: "{{ url('/mydata/update/data') }}",
            source: [
                @foreach($category as $row)
                    {value: "{{ $row->id }}", text: "{{ $row->name }}"},
                @endforeach
            ]
        });

        $('#category_id').editable({
            url: "{{ url('/mydata/update/data') }}",
            source: [
                @foreach($categoryID as $row)
                    {value: "{{ $row->id }}", text: "{{ $row->name }}"},
                @endforeach
            ]
        });
        $('#profession').editable({
            url: "{{ url('/mydata/update/data') }}",
            source: [
                @foreach($profession as $row)
                    {value: "{{ $row->id }}", text: "{{ $row->name }}"},
                @endforeach
            ]
        });

        $("input[type='radio']").on('click',function(){
            var table = $(this).data('table');
            var name = $(this).attr('name');
            var value = $(this).val();
            $.ajax({
                url: "{{ url("/mydata/update/table") }}/"+table,
                type: "POST",
                data: {
                    name: name,
                    value: value
                },
                success: function(data){
                    console.log(data);
                }
            })
        });
    </script>
@endsection
