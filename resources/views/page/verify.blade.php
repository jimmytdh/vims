@extends('app')

@section('css')

@endsection

@section('content')
    <h2 class="text-success title-header">Verify Registration</h2>
    <form action="{{ url("/verify") }}" method="post">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" value="{{ $search }}" placeholder="Search Lastname or Firstname" name="search" required>
            </div>

            <div class="form-group col-sm-3">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-search-plus"></i> Check
                </button>
            </div>
        </div>
    </form>
    @if(count($data) > 0)
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Suffix</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row->lastname }}</td>
                        <td>{{ $row->firstname }}</td>
                        <td>{{ $row->middlename }}</td>
                        <td>{{ $row->suffix }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i> No data found!
        </div>
    @endif
@endsection

@section('js')
    <script>
        @if(!Session::get("key"))
            var password = prompt("Please enter secret key");
            if (password == null || password == "") {
                location.reload();
            } else {
                $.ajax({
                    url: "{{ url('/key') }}",
                    type: "POST",
                    data: {
                        key: password
                    },
                    success: function(data){
                        if(data=='failed'){
                            location.reload();
                        }else{
                            alert("Success! You are authorized to access this page.")
                        }
                    }
                })
            }
        @endif
    </script>
@endsection
