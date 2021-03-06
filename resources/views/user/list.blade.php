@extends('app')

@section('title','Master List')
@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/bootstrap-editable.css') }}">
    <style>
        td,th {
            white-space: nowrap;
            padding-left: 10px;
        }
        tr.selected .text-success{
            color: yellow !important;
        }
        tr.selected .text-danger{
            color: white !important;
        }
        .editable { cursor: pointer; }
        .search { width: 100%; display: inline-block}
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
        <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
            <tr>
                <th rowspan="2">Action</th>
                <th><input type="text" data-column="1" class="search form-control form-control-sm" placeholder="Search Name"></th>
                <th><input type="text" data-column="2" class="search form-control form-control-sm" placeholder="Search With Comorbidity"></th>
                <th><input type="text" data-column="3" class="search form-control form-control-sm" placeholder="Search Division"></th>
                <th rowspan="2">Gender</th>
                <th rowspan="2">Age</th>
                <th><input type="text" data-column="6" class="search form-control form-control-sm" placeholder="Search Contact"></th>
                <th><input type="text" data-column="7" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="8" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="9" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="10" class="search form-control form-control-sm" placeholder="Search Consent"></th>
                <th rowspan="2">Date Updated</th>
            </tr>
            <tr>
                <th>Full Name</th>
                <th>With Comorbidity?</th>
                <th>Division</th>
                <th>Contact</th>
                <th>Schedule</th>
                <th>1st Dosage</th>
                <th>2nd Dosage</th>
                <th>Consent</th>
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
                processing: false,
                serverSide: false,
                ajax: "{{ url('/list') }}",
                columns: [
                    { data: 'action', name: 'action'},
                    { data: 'fullname', name: 'fullname'},
                    { data: 'w_comorbidity', name: 'w_comorbidity'},
                    { data: 'division', name: 'division'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'contact_no', name: 'contact_no'},
                    { data: 'schedule', name: 'schedule'},
                    { data: 'dosage1', name: 'dosage1'},
                    { data: 'dosage2', name: 'dosage2'},
                    { data: 'consent', name: 'consent'},
                    { data: 'updated_at', name: 'updated_at'},

                ],
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id)
                            .attr('data-willing', data.willing);
                },
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center align-middle' , targets: [0,2,5,10]},
                    { className: 'text-right' , targets: []},
                    { className: 'align-middle' , targets: [4]},
                ],
                "pageLength": 50,
                "order": [[ 1, "asc" ]],
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-copy"></i> Copy',
                        exportOptions: {
                            columns: [ 1,2,3,4,5,6,7,8,9,10 ]
                        }
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
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        title: '{{ 'List as of '.date("M d, Y h:i A") }}',

                        customize: function (doc) {
                            var colCount = new Array();
                            for(var i=0;i<=9;i++){
                                colCount.push('*');
                            }
                            doc.content[1].table.widths = colCount;
                            doc.content[1].margin = [ 50, 0, 0, 0 ] //left, top, right, bottom
                        },
                        exportOptions: {
                            columns: [ 1,2,3,4,5,6,7,8,9,10 ]
                        }
                    },{
                        text: '<i class="fa fa-eyedropper"></i> Vaccine',
                        className: 'btn btn-warning',
                        action: function () {
                            $("#vaccineModal").modal();
                            $(".count_ids").html(table.rows('.selected').data().length +' row(s) selected');
                            $(".load_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait...</div>');
                            var id = $(this).data('id');

                            setTimeout(function(){
                                var url = "{{ url('/vaccine/') }}";
                                $(".load_content").load(url);
                            },500);
                        }
                    },{
                        text: '<i class="fa fa-calendar"></i> Schedule',
                        className: 'btn btn-primary',
                        action: function () {
                            $("#scheduleModal").modal();
                            $(".count_ids").html(table.rows('.selected').data().length +' row(s) selected');
                        }
                    }
                ]
            });


            $('#dataTable tbody').on( 'click', 'tr', function (item) {
                if($(this).data('willing')=='Yes'){
                    $(this).toggleClass('selected');
                }
            } );

            $('#button').click( function () {
                alert( table.rows('.selected').data().length +' row(s) selected' );
            } );


            $('.search').bind('keyup', function(e){
                if(e.keyCode == 13) {
                    var column = $(this).data('column');
                    table
                        .column(column)
                        .search(this.value)
                        .draw();
                }
            });
            $('#dataTable_filter input').unbind();
            $('#dataTable_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                    var oTable = $('#dataTable').dataTable();
                    oTable.fnFilter(this.value);
                }
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
                var id_list = new Array();
                $.map(table.rows('.selected').nodes(), function (item) {
                    id_list.push($(item).data('id'));
                });
                formData.append('id_list',id_list);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        console.log(data);
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
        });
    </script>

    <script>
        var down=false;
        var scrollLeft=0;
        var x = 0;

        $('.table-responsive').mousedown(function(e) {
            down = true;
            scrollLeft = this.scrollLeft;
            x = e.clientX;
        }).mouseup(function() {
            down = false;
        }).mousemove(function(e) {
            if (down) {
                this.scrollLeft = scrollLeft + x - e.clientX;
            }
        }).mouseleave(function() {
            down = false;
        });
    </script>
@endsection
