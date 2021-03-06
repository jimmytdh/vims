@extends('app')

@section('css')

@endsection

@section('content')
    <h2 class="text-success title-header">Fix Barangay</h2>
    <form action="{{ url("/list/fix/brgy") }}" method="post">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" value="{{ $first->muncity }}" placeholder="Exact Keyword Muncity" name="muncity" required>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" value="{{ $first->barangay }}" placeholder="Search Keyword" name="search" required>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" placeholder="Exact Value" name="value" required>
            </div>
            <div class="form-group col-sm-3">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-search-plus"></i> Search and Update
                </button>
            </div>
        </div>
    </form>
    @if(count($data) > 0)
        <div class="table-responsive">
            <table id="dataTable" class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Province</th>
                    <th>Municipality/City</th>
                    <th>Barangay</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row->province }}</td>
                        <td>{{ $row->muncity }}</td>
                        <td>{{ $row->barangay }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> Fixed All!
        </div>
    @endif
@endsection

@section('js')

@endsection
