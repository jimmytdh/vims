@extends('app')

@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/style.css') }}">
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
                <th>PhilHealth ID</th>
                <th>Region</th>
                <th>Province</th>
                <th>Municipality/City</th>
                <th>Barangay</th>
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
                ajax: "{{ route('list.fix') }}",
                columns: [
                    { data: 'fullname', name: 'fullname'},
                    { data: 'philhealthid', name: 'philhealthid'},
                    { data: 'region', name: 'region'},
                    { data: 'province', name: 'province'},
                    { data: 'muncity', name: 'muncity'},
                    { data: 'barangay', name: 'barangay'},
                ],
                drawCallback: function (settings) {
                    makeEditable();
                },
                columnDefs: [
                    { className: 'text-center' , targets: [2,3,4]},
                    { className: 'text-right' , targets: []},
                ],
                "pageLength": 25
            });

            function makeEditable()
            {
                $('.edit').editable({
                    url: "{{ url('list/fix/update') }}",
                    type: 'text',
                    success: function (data){
                        console.log(data);
                    }
                });
            }

        });
    </script>
@endsection
