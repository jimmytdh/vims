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
            <a href="{{ url('export') }}" target="_blank" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Export
            </a>
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
                    <th>Date Updated</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>COVID History</th>
                    <th>With Allergy?</th>
                    <th>With Comorbidity?</th>
                    <th>Consent</th>
                    <th></th>
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
                ajax: "{{ route('list.data') }}",
                columns: [
                    { data: 'date_updated', name: 'date_updated'},
                    { data: 'fullname', name: 'fullname'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age', name: 'age'},
                    { data: 'history', name: 'history'},
                    { data: 'with_allergy', name: 'with_allergy'},
                    { data: 'with_comorbidity', name: 'with_comorbidity'},
                    { data: 'consent', name: 'consent'},
                    { data: 'action', name: 'action'},
                ],
                drawCallback: function (settings) {
                    deleteModal();
                },
                columnDefs: [
                    { className: 'text-center' , targets: [2,3,4]},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25,
                "order": [[ 1, "asc" ]]
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

            function deleteModal(){
                $('.btnDelete').on('click',function(e){
                    e.preventDefault();
                    var url = $(this).data('url');
                    var title = $(this).data('title');
                    $('.btnYes').attr('href',url);
                    $('.modal-title').html(title);
                });
            }

        });
    </script>
@endsection
