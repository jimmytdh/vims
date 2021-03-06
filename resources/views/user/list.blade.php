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
        tr.selected .text-success,tr.selected .text-info{
            color: yellow !important;
        }
        tr.selected .text-danger{
            color: white !important;
        }
        .editable { cursor: pointer; }
        .search { width: 100%; display: inline-block}
        .btn-success { border-color: #009246 !important;}
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

    <hr style="size: 2px;border:none;color:#ccc;">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
            <tr>
                <th rowspan="2">Action</th>
                <th><input type="text" data-column="1" class="search form-control form-control-sm" placeholder="Search Name"></th>
                <th><input type="text" data-column="2" class="search form-control form-control-sm" placeholder="Search List"></th>
                <th><input type="text" data-column="3" class="search form-control form-control-sm" placeholder="Search With Comorbidity"></th>
                <th><input type="text" data-column="4" class="search form-control form-control-sm" placeholder="Search Division"></th>
                <th rowspan="2">Gender</th>
                <th rowspan="2">Age</th>
                <th><input type="text" data-column="7" class="search form-control form-control-sm" placeholder="Search Contact"></th>
                <th><input type="text" data-column="8" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="9" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="10" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="11" class="search form-control form-control-sm" placeholder="Search Consent"></th>
                <th><input type="text" data-column="12" class="search form-control form-control-sm" placeholder="Search Date"></th>
                <th><input type="text" data-column="13" class="search form-control form-control-sm" placeholder="Search Date"></th>
            </tr>
            <tr>
                <th>Full Name</th>
                <th>List</th>
                <th>With Comorbidity?</th>
                <th>Division</th>
                <th>Contact</th>
                <th>Schedule</th>
                <th>1st Dosage</th>
                <th>2nd Dosage</th>
                <th>Consent</th>
                <th>Consent Updated</th>
                <th>Date Added</th>
            </tr>
            </thead>

        </table>
    </div>

@endsection

@section('modal')
    @include('user.modal')
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
                    { data: 'list', name: 'list'},
                    { data: 'w_comorbidity', name: 'w_comorbidity'},
                    { data: 'division', name: 'division'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'contact_no', name: 'contact_no'},
                    { data: 'schedule', name: 'schedule'},
                    { data: 'dosage1', name: 'dosage1'},
                    { data: 'dosage2', name: 'dosage2'},
                    { data: 'consent', name: 'consent'},
                    { data: 'consent_update', name: 'consent_update'},
                    { data: 'created_at', name: 'created_at'},
                ],
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id)
                            .attr('data-willing', data.willing);
                },
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center align-middle' , targets: [0,3,6,11]},
                    { className: 'text-right' , targets: []},
                    { className: 'align-middle' , targets: [4]},
                    {
                        targets: [0,3,5,7,10,11,12,13], visible: false, searchable: true
                    }
                ],
                "pageLength": 10,
                "order": [[ 1, "asc" ]],
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'colvis',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-copy"></i> Show'
                    },
                    {
                        extend: 'copy',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-copy"></i> Copy'
                    },{
                        text: '<i class="fa fa-list"></i> Group List',
                        className: 'btn btn-success',
                        action: function () {
                            $("#listModal").modal();
                            $(".count_ids").html(table.rows('.selected').data().length +' row(s) selected');
                        }
                    },{
                        text: '<i class="fa fa-eyedropper"></i> Vaccine',
                        className: 'btn btn-success',
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
                        className: 'btn btn-success',
                        action: function () {
                            $("#scheduleModal").modal();
                            $(".count_ids").html(table.rows('.selected').data().length +' row(s) selected');
                        }
                    },{
                        text: '<i class="fa fa-exchange"></i> Transfer',
                        className: 'btn btn-success',
                        action: function () {
                            $("#transferModal").modal();
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

            $('#dataTable').on('column-visibility.dt', function(e, settings, column, state ){
                //console.log('Column:', column, "State:", state);
                makeEditable();
            });

            $('body').on('keyup','.search', function(e){
                var column = $(this).data('column');
                search(column,this.value)
            });

            function search(column,value)
            {
                table
                    .column(column)
                    .search(value)
                    .draw();
            }
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
                // $('.edit').editable({
                //     url: url,
                //     type: 'text',
                //
                // });
                $('.consent').editable({
                    url: url,
                    source: [
                        {value: '01_Yes', text: 'Yes'},
                        {value: '02_No', text: 'No'},
                        {value: '03_Unknown', text: 'Unknown'}
                    ],
                    success: function(data){
                        console.log(data);
                    }
                });

                $('.editUser').editable({
                    url: "{{ url('/employees/update') }}",
                    source: [
                        {value: "0", text: "Empty"},
                        @foreach($divisions as $div)
                        {value: "{{ $div->id }}", text: "{{ $div->code }}"},
                        @endforeach
                    ],
                    success: function(data){
                        console.log(data);
                    }
                });

                $('.editList').editable({
                    url: "{{ route('vaccine.update.list') }}",
                    source: [
                        {value: "", text: "Empty"},
                        {value: "QSL 1", text: "QSL 1"},
                        {value: "QSL 2", text: "QSL 2"},
                        {value: "QSL 3", text: "QSL 3"},
                        {value: "Wait List", text: "Wait List"},
                        {value: "Outside", text: "Outside"},
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
            $("body").on('submit',"#groupListForm",function(e){
                e.preventDefault();
                showLoader();
                $("#listModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

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

            $("body").on('submit','#transferForm',function (e){
                e.preventDefault();
                showLoader();
                $("#transferModal").modal('hide');
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
                            // var oTable = $('#dataTable').dataTable();
                            // oTable.fnDraw(false);
                            // hideLoader();
                            location.reload();
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
