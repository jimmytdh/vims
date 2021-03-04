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
    <h2 class="text-success title-header">Fix Data</h2>

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

        });
    </script>
@endsection
