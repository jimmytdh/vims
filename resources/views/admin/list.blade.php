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
        .editable {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h2 class="text-success title-header">
        Master List
        <span class="float-right">
            <a href="#uploadModal" data-toggle="modal" data-backdrop="static" target="_blank" class="btn btn-warning btn-sm">
                <i class="fa fa-cloud-upload"></i> Upload
            </a>
            <a href="{{ url('export') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Export
            </a>
            <a href="#uploadCompareModal" data-toggle="modal" data-backdrop="static" target="_blank" class="btn btn-info btn-sm">
                <i class="fa fa-gears"></i> Upload and Compare
            </a>
            @if(Session::get('id_list'))
            <a href="{{ url('export/lacking') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Export Update
            </a>
            @endif
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
                <th>Full Name</th>
                <th>Date Updated</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Facility</th>
                <th>Action</th>
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
                ajax: "{{ route('list.data') }}",
                columns: [
                    { data: 'fullname', name: 'fullname'},
                    { data: 'date_updated', name: 'date_updated'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'employer_name', name: 'employer_name'},
                    { data: 'action', name: 'action'},
                ],
                drawCallback: function (settings) {
                    deleteModal();
                },
                columnDefs: [
                    { className: 'text-center' , targets: [3]},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25,
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
                    }
                ],
            });
            $('#dataTable_filter input').unbind();
            $('#dataTable_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                    var oTable = $('#dataTable').dataTable();
                    oTable.fnFilter(this.value);
                }
            });

            function deleteModal(){
                $('.btnDelete').on('click',function(e){
                    e.preventDefault();
                    var url = $(this).data('url');
                    var title = $(this).data('title');
                    $('.btnYes').attr('href',url);
                    $('.modal-title').html(title);
                });

                var url = "{{ url('/list/fix/update') }}";
                $('.consent').editable({
                    url: url,
                    source: [
                        {value: '01_Yes', text: 'Yes'},
                        {value: '02_No', text: 'No'},
                        {value: '03_Unknown', text: 'Unknown'}
                    ]
                });
            }
        });
    </script>
@endsection
