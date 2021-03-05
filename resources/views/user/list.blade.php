@extends('app')

@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/bootstrap-editable.css') }}">
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
        .editable { cursor: pointer; }
    </style>
@endsection

@section('content')
    <h2 class="text-success title-header">
        Master List
        <span class="float-right">
            <a href="{{ url('export/confirmed') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Download List (YES)
            </a>
        </span>
    </h2>

    <div class="table-responsive">
        <table id="dataTable" class="table table-sm table-striped">
            <thead>
            <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Suffix</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Contact</th>
                <th>COVID History</th>
                <th>Consent</th>
                <th>ID Card</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection

@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-editable/js/bootstrap-editable.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/list') }}",
                columns: [
                    { data: 'lastname', name: 'lastname'},
                    { data: 'firstname', name: 'firstname'},
                    { data: 'middlename', name: 'middlename'},
                    { data: 'suffix', name: 'suffix'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'contact_no', name: 'contact_no'},
                    { data: 'history', name: 'history'},
                    { data: 'consent', name: 'consent'},
                    { data: 'action', name: 'action'},
                ],
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center' , targets: [2,3,4]},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25,
                "order": [[ 0, "asc" ]]
            });

            function makeEditable()
            {
                var url = "{{ url('/list/fix/update') }}";
                $('.edit').editable({
                    url: url,
                    type: 'text',
                    success: function(data){
                        console.log(data);
                    }
                });
                $('.consent').editable({
                    url: url,
                    source: [
                        {value: '01_Yes', text: 'Yes'},
                        {value: '02_No', text: 'No'},
                        {value: '03_Unknown', text: 'Unknown'}
                    ]
                });
            }
            $('#dataTable_filter input').unbind();
            $('#dataTable_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                    var oTable = $('#dataTable').dataTable();
                    oTable.fnFilter(this.value);
                }
            });
            $('#dataTable tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );
        });
    </script>
@endsection
