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
        Vaccinees <small class="text-danger">({{ date('F d, Y',strtotime($date)) }})</small>
    </h2>

    <hr style="size: 2px;border:none;color:#ccc;">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
            <tr>
                <th>Action</th>
                <th>Full Name</th>
                <th>Facility</th>
                <th>Category</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Vaccination Date</th>
                <th>Manufacturer</th>
                <th>Dose</th>
                <th>Deferral</th>
                <th>Consent</th>
                <th>Reason for Refusal</th>
                <th>Status</th>
            </tr>
            </thead>

        </table>
    </div>

@endsection

@section('modal')
    @include('vas.modal')
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
                ajax: "{{ url('/list/vas') }}",
                columns: [
                    { data: 'action', name: 'action'},
                    { data: 'fullname', name: 'fullname'},
                    { data: 'facility', name: 'facility'},
                    { data: 'category', name: 'category'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'vaccination_date', name: 'vaccination_date'},
                    { data: 'vaccine_manufacturer', name: 'vaccine_manufacturer'},
                    { data: 'dose', name: 'dose'},
                    { data: 'deferral', name: 'deferral'},
                    { data: 'consent', name: 'consent'},
                    { data: 'refusal_reason', name: 'refusal_reason'},
                    { data: 'status', name: 'status'},
                ],
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id);
                },
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center align-middle' , targets: []},
                    { className: 'text-right' , targets: []},
                    { className: 'align-middle' , targets: []},
                    {
                        targets: [2,3,4,10,11,12], visible: false, searchable: true
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
                        text: '<i class="fa fa-file-excel-o"></i> Export',
                        className: 'btn btn-success',
                        action: function () {
                            location.href = "{{ url('/export/vas') }}";
                        }
                    },{
                        text: '<i class="fa fa-calendar"></i> Change Date',
                        className: 'btn btn-success',
                        action: function () {
                            $("#calendarModal").modal();
                        }
                    }
                    @if(auth()->user()->isAdmin())
                    ,{
                        text: '<i class="fa fa-cloud-upload"></i> Upload List',
                        className: 'btn btn-warning',
                        action: function () {
                            $("#uploadModal").modal();
                        }
                    }
                    @endif
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
                $('a[href="#vaccinationModal"]').on('click',function(){
                    $("#vaccinationContent").html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait...</div>');
                    var id = $(this).data('id');
                    var url = "{{ url('/vas/vaccination') }}/"+id;
                    setTimeout(function(){
                        $("#vaccinationContent").load(url);
                    },500);
                });

                $('a[href="#healthModal"]').on('click',function(){
                    $("#healthContent").html('<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait...</div>');
                    var id = $(this).data('id');
                    var url = "{{ url('/vas/health') }}/"+id;
                    setTimeout(function(){
                        $("#healthContent").load(url);
                    },500);
                });

                $('a[href="#nextVisitModal"]').on('click',function(){
                    var id = $(this).data('id');
                    var date = $(this).data('date');
                    $("#nextDate").val(date);
                    $("#vac_id").val(id);
                });

                $('a[href="#statusModal"]').on('click',function(){
                    var id = $(this).data('id');
                    $("#status_id").val(id);
                });

                $('.vaccination_date').editable({
                    url: "{{ url('/vas/editable') }}",
                    format: 'yyyy-mm-dd',
                    viewformat: 'M dd, yyyy',
                    datepicker: {
                        weekStart: 0
                    },
                    success: function(data){
                        var oTable = $('#dataTable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }

            $('body').on('submit','#vaccinationForm',function(e){
                e.preventDefault();
                showLoader();
                $("#vaccinationModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

            $('body').on('submit','#healthForm',function(e){
                e.preventDefault();
                showLoader();
                $("#healthModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

            $('body').on('submit','#nextVisitForm',function(e){
                e.preventDefault();
                showLoader();
                $("#nextVisitModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

            $('body').on('submit','#statusForm',function(e){
                e.preventDefault();
                showLoader();
                $("#statusModal").modal('hide');
                var url = $(this).attr('action');
                var formData = new FormData(this);
                submitForm(url, formData);
            });

            $('body').on('change','.consent',function(){
                var ans = $(this).val();
                if(ans=='01_Yes'){
                    $('.refusal_reason').addClass('hidden');
                    $('.consent_content').removeClass('hidden');
                }else if(ans=='02_No'){
                    $('.refusal_reason').removeClass('hidden');
                    $('.consent_content').addClass('hidden');
                }
            });

            $('body').on('click','.btnDelete',function(e){
                e.preventDefault();
                var url = $(this).data('url');
                var title = $(this).data('title');
                $('.btnYes').attr('href',url);
                $('.modal-title').html(title);
            });

            $('body').on('click','.btnYes',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                $("#deleteModal").modal('hide');
                showLoader();
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(){
                        setTimeout(function(){
                            var oTable = $('#dataTable').dataTable();
                            oTable.fnDraw(false);
                            hideLoader();
                        },500);
                    }
                })
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
                        console.log(data);
                        setTimeout(function(){
                            var oTable = $('#dataTable').dataTable();
                            oTable.fnDraw(false);
                            hideLoader();
                            //location.reload();
                        },500);
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
    @include('script.health')
@endsection
