@extends('app')

@section('title','CBCR Report')
@section('css')
    <style>
        .facility {

            line-height: 90%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="alert alert-danger">
                <h3 class="title-header">{{ date('F d, Y',strtotime($date)) }}</h3>

                @foreach($header as $key => $value)
                    <?php
                        $row = 'question_'.$key;
                    ?>
                    <div class="form-group">
                        <span class="font-italic">{{ $key }}. {{ $value }}</span> :
                        <span class="font-weight-bold"><u>{{ $data->$row }}</u></span>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="col-sm-8">
            <h2 class="title-header">CBCR Report</h2>
            <form action="{{ url('/cbcr/date') }}" method="post" class="form-inline">
                {{ csrf_field() }}
                <input type="date" name="report_date" value="{{ $date }}" class="form-control">
                <button type="submit" class="btn btn-success btn-flat ml-2">
                    <i class="fa fa-calendar-check-o"></i> Change Date
                </button>
            </form>
            <hr style="height:2px;border:none;color:#ccc;background-color: #ccc;">
            <div class="row mt-2">
                @foreach($facilities as $facility)
                <?php
                    $len = strlen($facility);
                ?>
                <div class="col-sm-4">
                    <div class="alert alert-info text-center">
                        @if($len > 20)
                            <span class="facility">{{ substr($facility, 0, 20) }}...</span>
                        @else
                            <span class="facility">{{ $facility }}</span>
                        @endif

                        <hr>
                        <h1>{{ \App\Http\Controllers\QuickCountController::countPerFacility($facility) }}</h1>
                    </div>
                </div>
                @endforeach
            </div>
            <hr style="height:2px;border:none;color:#ccc;background-color: #ccc;">
            <form action="{{ url('/cbcr/update') }}" method="post">
                {{ csrf_field() }}
                <div class="form-row">
                    @foreach($header as $key => $value)
                        <?php $row = 'question_'.$key; ?>
                        <div class="col-sm-6 form-group">
                            <label>{{ $value }}</label>
                            @if($key=='20' || $key=='21' || $key=='22' || $key=='23')
                                <textarea name="question_{{ $key }}" rows="5" class="form-control" style="resize: none;">{!! $data->$row !!}</textarea>
                            @else
                                <input type="text" class="form-control" value="{{ \App\Http\Controllers\QuickCountController::countReport($key) }}" name="question_{{ $key }}">
                            @endif
                        </div>
                    @endforeach
                    <button class="btn btn-lg btn-success btn-block btn-flat">
                        <i class="fa fa-check"></i> Update Report
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection



@section('js')

@endsection
