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
            <a href="{{ url('export/confirmed') }}" target="_blank" class="btn btn-primary btn-sm">
                <i class="fa fa-file-excel-o"></i> Confirmed (YES)
            </a>
            <a href="{{ url('export/1stDosage') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> 1st Dosage
            </a>
            <a href="{{ url('export/2ndDosage') }}" target="_blank" class="btn btn-info btn-sm">
                <i class="fa fa-file-excel-o"></i> 2nd Dosage
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
                <th>Gender</th>
                <th>Age</th>
                <th>Contact</th>
                <th>Vaccine</th>
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
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'contact_no', name: 'contact_no'},
                    { data: 'status', name: 'status'},
                    { data: 'consent', name: 'consent'},
                    { data: 'action', name: 'action'},
                ],
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center' , targets: [3,4,5,7]},
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

                $('a[href="#vaccineModal"]').on('click',function (){
                    $(".load_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait...</div>');
                    var id = $(this).data('id');
                    setTimeout(function(){
                        var url = "{{ url('/vaccine/') }}/"+id;
                        $(".load_content").load(url);
                    },500);
                });
            }
            $("body").on('submit',"#vaccineForm",function(e){
                e.preventDefault();
                showLoader();
                $("#vaccineModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        setTimeout(function(){
                            var oTable = $('#dataTable').dataTable();
                            oTable.fnDraw(false);
                            console.log(data);
                            hideLoader();
                        },1000);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
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

    <script>

    </script>
@endsection
