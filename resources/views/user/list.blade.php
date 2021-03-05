@extends('app')

@section('title','List as of '.date('M d Y h i a'))
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
{{--            <a href="{{ url('export/confirmed') }}" target="_blank" class="btn btn-primary btn-sm">--}}
{{--                <i class="fa fa-file-excel-o"></i> Confirmed (YES)--}}
{{--            </a>--}}
{{--            <a href="{{ url('export/1stDosage') }}" target="_blank" class="btn btn-success btn-sm">--}}
{{--                <i class="fa fa-file-excel-o"></i> 1st Dosage--}}
{{--            </a>--}}
{{--            <a href="{{ url('export/2ndDosage') }}" target="_blank" class="btn btn-info btn-sm">--}}
{{--                <i class="fa fa-file-excel-o"></i> 2nd Dosage--}}
{{--            </a>--}}
        </span>
    </h2>

    <div class="table-responsive">
        <table id="dataTable" class="table table-sm table-striped">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Division</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Contact</th>
                <th>Schedule</th>
                <th>1st Dosage</th>
                <th>2nd Dosage</th>
                <th>Consent</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection

@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ url('/plugins/DataTables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-editable/js/bootstrap-editable.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/list') }}",
                columns: [
                    { data: 'fullname', name: 'fullname'},
                    { data: 'division', name: 'division'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'contact_no', name: 'contact_no'},
                    { data: 'schedule', name: 'schedule'},
                    { data: 'dosage1', name: 'dosage1'},
                    { data: 'dosage2', name: 'dosage2'},
                    { data: 'consent', name: 'consent'},
                    { data: 'action', name: 'action'},
                ],
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center' , targets: [3,4,5,6,8]},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25,
                "order": [[ 0, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-copy"></i> Copy Data'
                    },{
                        extend: 'print',
                        className: 'btn btn-info',
                        text: '<i class="fa fa-print"></i> Print'
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        className: 'btn btn-danger',
                        text: '<i class="fa fa-file-pdf-o"></i> Download PDF',
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        },
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5,6,7]
                        }
                    },{
                        extend: 'colvis',
                        className: 'btn btn-warning',
                        text: '<i class="fa fa-filter"></i> Filter Columns',
                    }
                ],
            });

            function makeEditable()
            {
                var url = "{{ url('/list/fix/update') }}";
                $('.edit').editable({
                    url: url,
                    type: 'text',

                });
                $('.consent').editable({
                    url: url,
                    source: [
                        {value: '01_Yes', text: 'Yes'},
                        {value: '02_No', text: 'No'},
                        {value: '03_Unknown', text: 'Unknown'}
                    ]
                });

                $('.editUser').editable({
                    url: "{{ url('/employees/update') }}",
                    source: [
                        @foreach($divisions as $div)
                        {value: "{{ $div->id }}", text: "{{ $div->code }}"},
                        @endforeach
                    ],
                    success: function(data){
                        console.log(data);
                    }
                });

                $('a[href="#vaccineModal"]').on('click',function (){
                    $(".load_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait...</div>');
                    var id = $(this).data('id');
                    setTimeout(function(){
                        var url = "{{ url('/vaccine/') }}/"+id;
                        $(".load_content").load(url);
                    },500);
                });

                $('a[href="#scheduleModal"]').on('click',function (){
                    var id = $(this).data('id');
                    $("#schedule_id").val(id);
                });
            }
            $("body").on('submit',"#vaccineForm",function(e){
                e.preventDefault();
                showLoader();
                $("#vaccineModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

            $("body").on('submit','#scheduleForm',function (e){
                e.preventDefault();
                showLoader();
                $("#scheduleModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

            function submitForm(url,formData)
            {
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
                            hideLoader();
                        },1000);
                    },
                    error: function(data){
                        console.log(data);
                    }
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

    <script>

    </script>
@endsection
