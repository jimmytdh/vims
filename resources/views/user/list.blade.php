@extends('app')

@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
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
            <a href="{{ url('export/confirmed') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Download List (YES)
            </a>
        </span>
    </h2>

    <div class="table-responsive">
        <table id="dataTable" class="table table-sm table-striped">
            <thead>
            <tr>
                <th>Name</th>
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
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/list') }}",
                columns: [
                    { data: 'fullname', name: 'fullname'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'contact_no', name: 'contact_no'},
                    { data: 'history', name: 'history'},
                    { data: 'consent', name: 'consent'},
                    { data: 'action', name: 'action'},
                ],
                drawCallback: function (settings) {

                },
                columnDefs: [
                    { className: 'text-center' , targets: [2,3,4]},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25,
                "order": [[ 1, "asc" ]]
            });
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
