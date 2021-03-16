@extends('app')

@section('title','Manage Doctors')
@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/style.css') }}">
    <style>
        .editable { cursor: pointer; }
        .btn-success { background: #118146 !important; color: #fff !important;}
        .btn-circle { border-radius: 50%; }
    </style>
@endsection

@section('content')
    <div id="loader-wrapper" style="visibility: hidden;">
        <div id="loader"></div>
    </div>
    <h2 class="title-header">Manage Vaccinators</h2>
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Vaccinator</h3>
                </div>
                <form action="{{ route('add.vaccinator') }}" id="submitForm">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="name" required autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label>Profession</label>
                            <select name="profession" class="custom-select" required>
                                <option value="">Select...</option>
                                <option>Doctor</option>
                                <option>Nurse</option>
                                <option>Midwife</option>
                                <option>Pharmacist</option>
                            </select>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" id="btnSave" class="btn btn-success btn-block">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-sm-9">
            <div class="table-responsive p-2">
                <table id="dataTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Profession</th>
                        <th>Date Updated</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal" tabindex="-1" role="dialog" id="modalLoadError">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Unable to Fetch Data</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-default btn-block" onclick="window.location.replace('{{ url('/patients') }}')">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-success btn-block" onclick="window.location.reload();">
                                <i class="fa fa-refresh"></i> Reload
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-editable/js/bootstrap-editable.js') }}"></script>
    <script>

        $(document).ready(function() {

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/vas/vaccinator') }}",
                columns: [
                    { data: 'name', name: 'name'},
                    { data: 'profession', name: 'profession'},
                    { data: 'updated_at', name: 'updated_at'}
                ],
                drawCallback: function (settings) {
                    makeEditable();
                }
            });


            function makeEditable()
            {
                $.fn.editable.defaults.mode = 'popup';
                $('.edit').editable({
                    url: "{{ route('update.vaccinator') }}",
                    type: 'text',
                    emptytext: 'N/A',
                    success: function(){
                        var oTable = $('#dataTable').dataTable();
                        oTable.fnDraw(false);
                    }
                });

                $('.profession').editable({
                    url: "{{ route('update.vaccinator') }}",
                    source: [
                        {value: 'Doctor', text: 'Doctor'},
                        {value: 'Nurse', text: 'Nurse'},
                        {value: 'Midwife', text: 'Midwife'},
                        {value: 'Pharmacist', text: 'Pharmacist'},
                    ],
                    emptytext: 'N/A',
                    success: function(){
                        var oTable = $('#dataTable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }

            $('#dataTable').on('click','.btn-delete',function(){
                var id = $(this).data('id');
                if(confirm("Are you sure you want to delete this record?") == true) {
                    var id = id;
                    $.ajax({
                        type: "POST",
                        url: "{{ route("destroy.vaccinator") }}",
                        data: { id: id },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#dataTable').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(err){
                            console.log('error');
                        }
                    });
                }
            });

            $("#submitForm").on('submit',function (e) {
                e.preventDefault();
                $('#btnSave').html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
                $('#btnSave').attr('disabled',true);
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('add.vaccinator') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        var oTable = $('#dataTable').dataTable();
                        oTable.fnDraw(false);
                        setTimeout(function(){
                            $('#btnSave').html('<i class="fa fa-save"></i> Save');
                            $('#btnSave').attr('disabled',false);
                            $('#submitForm').trigger('reset');
                        },1000);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });


        });
    </script>
@endsection
