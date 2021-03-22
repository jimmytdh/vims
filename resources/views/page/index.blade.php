<?php
    use App\Http\Controllers\QuickCountController;
?>
@extends('app')

@section('css')
    <link href="{{ url('/plugins/chart.js/dist/Chart.min.css') }}" rel="stylesheet">
    <style>
        .small-box p{
            color: #fff !important;
        }
        .number { font-size: 6rem; }
        .sub_number { font-size: 3rem; }
        .bulletin { font-weight: bold; }
        .bg-navy { background: #06466a; color: #fff;}
    </style>
@endsection
@section('content')
    <h2 class="text-success title-header">
        <img src="{{ url('/images/bida_plus_logo.png') }}" height="50px" />
        VACCINATION BULLETIN
    </h2>
    <div class="clearfix"></div>
    <div class="row bulletin">
        <div class="col-sm-4 m-0 p-4 bg-yellow text-center">
            VACCINATED TODAY
            <h1 class="number">{{ number_format(QuickCountController::countVaccinated(null,null,date('Y-m-d'))) }}</h1>
            TOTAL VACCINATED INDIVIDUALS
            <h3 class="sub_number">{{ number_format(QuickCountController::countVaccinated(null,null,null)) }}</h3>
        </div>
        <div class="col-sm-4 m-0 p-4 bg-aqua text-center">
            VACCINATED WITH ASTRAZENECA
            <h1 class="number">{{ number_format(QuickCountController::countVaccinated(null,'Astrazeneca',date('Y-m-d'))) }}</h1>
            TOTAL VACCINATED WITH ASTRAZENECA
            <h3 class="sub_number">{{ number_format(QuickCountController::countVaccinated(null,'Astrazeneca',null)) }}</h3>
        </div>
        <div class="col-sm-4 m-0 p-4 bg-red text-center">
            VACCINATED WITH SINOVAC
            <h1 class="number">{{ number_format(QuickCountController::countVaccinated(null,'Sinovac',date('Y-m-d'))) }}</h1>
            TOTAL VACCINATED WITH SINOVAC
            <h3 class="sub_number">{{ number_format(QuickCountController::countVaccinated(null,'Sinovac',null)) }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 m-0 p-2 text-center">
            <h4><span class="sub_number">{{ number_format(QuickCountController::countReport('05',date('Y-m-d'))) }}</span> Deferred Vaccinees</h4>
        </div>
        <div class="col-sm-4 m-0 p-2 text-center">
            <h4><span class="sub_number">{{ number_format(QuickCountController::countReport('17',date('Y-m-d'))) }}</span> Mild AEFI</h4>
        </div>
        <div class="col-sm-4 m-0 p-2 text-center">
            <h4><span class="sub_number">{{ number_format(QuickCountController::countReport('18',date('Y-m-d'))) }}</span> Serious AEFI</h4>
        </div>
    </div>
    <div class="col-sm-12 p-3 text-white bg-success text-center">
        <h1>
            <span class="sub_number">{{ $per }}%</span> Vaccinated!<br>
            <strong>{{ $vaccinated }}</strong> out of <strong>{{ $target }}</strong> CSMC Employee Vaccinated
        </h1>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-hover table-striped">
            <thead class="bg-navy">
                <tr>
                    <th>Facility</th>
                    <th class="text-center">AstraZeneca</th>
                    <th class="text-center">Sinovac</th>
                    <th class="text-center">Today</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facilities as $fac)
                <tr>
                    <td>{{ $fac }}</td>
                    <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac,'Astrazeneca',date('Y-m-d'))) }}</td>
                    <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac,'Sinovac',date('Y-m-d'))) }}</td>
                    <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac,null,date('Y-m-d'))) }}</td>
                    <th class="text-center">{{ number_format(QuickCountController::countVaccinated($fac,null,null)) }}</th>
                </tr>
                @endforeach
            </tbody>
            <tfoot style="border-top: 2px solid #333;">
                <tr>
                    <th>TOTAL</th>
                    <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,'Astrazeneca',date('Y-m-d'))) }}</td>
                    <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,'Sinovac',date('Y-m-d'))) }}</td>
                    <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,null,date('Y-m-d'))) }}</td>
                    <th class="text-center">{{ number_format(QuickCountController::countVaccinated(null,null,null)) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection


@section('js')

@endsection
