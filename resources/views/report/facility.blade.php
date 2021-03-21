@extends('app')

@section('title','Facility Report')
@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <style>
        td,th {
            white-space: nowrap;
            padding-left: 10px;
        }
        tr.selected .text-success,tr.selected .text-info{
            color: yellow !important;
        }
        tr.selected .text-danger{
            color: white !important;
        }
        .search { width: 100%; display: inline-block}
        .btn-success { border-color: #009246 !important;}
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="title-header">Facility Report</h2>
            <form action="{{ url('/report/facility') }}" method="post" class="form-inline mt-2">
                {{ csrf_field() }}
                <select name="facility" class="custom-select" required>
                    <option value="">Select...</option>
                    <?php $facilities = \App\Http\Controllers\VasController::facilities(); ?>
                    @foreach($facilities as $fac)
                        <option @if($facility == $fac) selected @endif>{{ $fac }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success btn-flat ml-2">
                    <i class="fa fa-calendar-check-o"></i> Set Facility
                </button>
            </form>
            <hr style="height:2px;border:none;color:#ccc;background-color: #ccc;">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Age</th>
                        <th>Vaccine</th>
                        <th>1st Dose</th>
                        <th>2nd Dose</th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>

    </div>
@endsection



@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ url('/report/facility') }}",
                columns: [
                    { data: 'lastname', name: 'lastname'},
                    { data: 'firstname', name: 'firstname'},
                    { data: 'middlename', name: 'middlename'},
                    { data: 'age', name: 'age'},
                    { data: 'vaccine_manufacturer', name: 'vaccine_manufacturer'},
                    { data: 'dose1', name: 'dose1'},
                    { data: 'dose2', name: 'dose2'},
                ],
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id);
                },
                drawCallback: function (settings) {

                },
                columnDefs: [
                    { className: 'text-center align-middle' , targets: []},
                    { className: 'text-right' , targets: []},
                    { className: 'align-middle' , targets: []},

                ],
                "pageLength": 10,
                "order": [[ 0, "asc" ]],
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-copy"></i> Copy'
                    },{
                        text: '<i class="fa fa-file-excel-o"></i> Export',
                        className: 'btn btn-success',
                        action: function () {
                            location.href = "{{ url('/report/export') }}";
                        }
                    }
                ]
            });

        });
    </script>
@endsection
