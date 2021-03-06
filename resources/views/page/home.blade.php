@extends('app')

@section('css')
    <link href="{{ url('/plugins/chart.js/dist/Chart.min.css') }}" rel="stylesheet">
    <style>
        .small-box p{
            color: #fff !important;
        }
    </style>
@endsection
@section('content')
    <h2 class="text-success title-header">Dashboard <small class="text-muted">Control Panel</small></h2>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 id="today">0</h3>
                    <p>Scheduled<br>Today</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
                <a href="{{ url('/schedule') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="tomorrow">0</h3>
                    <p>Scheduled<br>Tomorrow</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar"></i>
                </div>
                <a href="{{ url('/patients') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 id="v_today">0</h3>
                    <p>Vaccinated Today<br><em>({{ date('D') }})</em></p>
                </div>
                <div class="icon">
                    <i class="fa fa-eyedropper"></i>
                </div>
                <a href="{{ url('/patients') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 id="v_dosage1">0</h3>
                    <p>Vaccinated<br><em>(1st Dosage)</em></p>
                </div>
                <div class="icon">
                    <i class="fa fa-pie-chart"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $per }}<sup style="font-size: 20px">%</sup></h3>
                    <p class="text-white">
                        {{ $total }} out of {{ $target }} Target
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ url('/list/master') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $yesPer }}<sup style="font-size: 20px">%</sup></h3>
                    <p class="text-white">
                        {{ $consent }} out of {{ $total }} Willing to be Vaccinated
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-thumbs-up"></i>
                </div>
                <a href="{{ url('/list/master') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Vaccination Activity</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="areaChart" style="height:250px"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Waiting List over Vaccinated</h3>
                </div>
                <div class="box-body">
                    <canvas id="donutChart" style="height:250px"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
    <script src="{{ url('/plugins/chart.js/dist/Chart.js') }}"></script>
    <script src="{{ url('/plugins/chart.js/dist/utils.js') }}"></script>
    <script>
        showLoader();
    </script>
    @include('data.config')
    @include('data.chart')
    @include('data.donut')
@endsection
