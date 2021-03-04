@extends('app')

@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <style>
        td {
            white-space: nowrap;
        }
        .edit {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h2 class="text-success title-header">
        Employee List
        <div class="float-right">
            <form action="{{ url('/employees/search') }}" method="post" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group">
                    <select name="search" id="search" class="custom-select mr-1 mt-1">
                        <option value="">Select Division</option>
                        @foreach($division as $row)
                        <option {{ (Session::get('division') == $row->id ? 'selected':'') }} value="{{ $row->id }}">{{ $row->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </h2>

    <div class="table-responsive">
        <table id="dataTable" class="table table-sm table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Division</th>
                <th>Status</th>
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
                ajax: "{{ route('list.employee') }}",
                columns: [
                    { data: 'fullname', name: 'fullname'},
                    { data: 'designation', name: 'designation'},
                    { data: 'division', name: 'division'},
                    { data: 'status', name: 'status'}
                ],
                drawCallback: function (settings) {

                },
                columnDefs: [
                    { className: 'text-center' , targets: []},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25
            });

            $('#dataTable_filter input').unbind();
            $('#dataTable_filter input').bind('keyup', function(e) {
                if(e.keyCode == 13) {
                    var oTable = $('#dataTable').dataTable();
                    oTable.fnFilter(this.value);
                }
            });

        });
    </script>
@endsection
