@extends('app')

@section('css')
    <style>
        td {
            white-space: nowrap;
        }
        tr.selected .text-success{
            color: yellow !important;
        }
        tr.selected .text-danger{
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <h2 class="text-success title-header">
        Master List
        <span class="float-right">
            <a href="{{ url('export') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Export
            </a>
        </span>
    </h2>
    @if($countRecords > 0)
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i> {{ $countRecords }} new records found!
            <div class="form-group float-right">
                <a href="#deleteModal" data-url="{{ url('/list/delete') }}" data-title="Delete Files?" data-backdrop="static" data-toggle="modal" class="btnDelete btn btn-danger btn-sm" style="margin-top: -3px;">
                    <i class="fa fa-times"></i> Ignore
                </a>
                <a href="{{ url('/list/upload') }}" class="btn btn-success btn-sm" style="margin-top: -3px;">
                    <i class="fa fa-upload"></i> Sync
                </a>
            </div>
        </div>
        <div class="clearfix"></div>
    @endif

    @if(session('duplicate'))
        <div class="alert alert-info">
            <i class="fa fa-exclamation-triangle"></i> Successfully saved and {{ session('duplicate') }} records updated.
        </div>
    @endif

    @if(session('saved'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> Successfully Saved.
        </div>
    @endif

    @if(session('upload'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> CSV File Successfully upload. Please click the sync button!
        </div>
    @endif

    @if(session('delete'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> Successfully deleted from the list.
        </div>
    @endif
    <div class="table-responsive">
        <table id="dataTable" class="table table-sm table-striped">
            <thead>
            <tr>
                <th>Date Updated</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>COVID History</th>
                <th>With Allergy?</th>
                <th>With Comorbidity?</th>
                <th>Consent</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($data) > 0)
                @foreach($data as $row)
                    <?php
                    $middlename = substr($row->middlename,0,1);
                    $suffix = ($row->suffix!='NA') ? $data->suffix: '';
                    $name = "$row->lastname, $row->firstname $middlename. $suffix";
                    $header = array(
                        'allergy_01',
                        'allergy_02',
                        'allergy_03',
                        'allergy_04',
                        'allergy_05',
                        'allergy_06',
                        'allergy_07',
                    );
                    $allergy = 'No';
                    foreach($header as $h){
                        if($row->$h=='01_Yes')
                            $allergy = '<span class="text-danger">With Allergy</span>';
                    }
                    ?>
                    <tr>
                        <td class="text-danger">{{ date('M d h:ia',strtotime($row->updated_at)) }}</td>
                        <td class="text-success">{{ $name }}</td>
                        <td>{{ ($row->sex=='02_Male') ? 'Male' : 'Female' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->birthdate)->diff(\Carbon\Carbon::now())->format('%y') }}</td>
                        <td>{!!  ($row->covid_history=='02_No') ? 'No' : '<span class="text-danger">Yes</span>' !!}</td>
                        <td>{{ $allergy }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="9">No data found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection

@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.btnDelete').on('click',function(e){
                e.preventDefault();
                var url = $(this).data('url');
                var title = $(this).data('title');
                $('.btnYes').attr('href',url);
                $('.modal-title').html(title);
            });

        });
    </script>
@endsection
