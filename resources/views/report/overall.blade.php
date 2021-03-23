<?php
    use App\Http\Controllers\QuickCountController;
?>
@extends('app')

@section('title','Facility Report')
@section('css')
    <style>
        td { white-space: nowrap; }
        th { vertical-align: middle !important; text-align: center;}
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="title-header">Overall Report</h2>
            <hr style="height:2px;border:none;color:#ccc;background-color: #ccc;">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th rowspan="2">Facility</th>
                        @while($start != $end)
                        <?php
                            $start = \Carbon\Carbon::parse($start)->addDay(1)->format('Y-m-d');
                        ?>
                        <th class="text-center" colspan="2">{{ date("M d",strtotime($start)) }}</th>
                        @endwhile
                        <th colspan="2">
                            TOTAL
                        </th>
                    </tr>
                    <tr>
                        @for($i=0; $i < $totalDays; $i++)
                            <th>Astrazeneca</th>
                            <th>Sinovac</th>
                        @endfor
                            <th>Astrazeneca</th>
                            <th>Sinovac</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($facilities as $fac)
                        <?php $start = $tmpStart; ?>
                        <tr>
                            <td>{{ $fac->name }}</td>
                            @while($start != $end)
                                <?php
                                $start = \Carbon\Carbon::parse($start)->addDay(1)->format('Y-m-d');
                                ?>
                                <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac->name,'Astrazeneca',$start)) }}</td>
                                <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac->name,'Sinovac',$start)) }}</td>
                            @endwhile
                            <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac->name,'Astrazeneca',null)) }}</td>
                            <td class="text-center">{{ number_format(QuickCountController::countVaccinated($fac->name,'Sinovac',null)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-success text-white">
                        <th>TOTAL</th>
                        <?php $start = $tmpStart; ?>
                        @while($start != $end)
                            <?php
                            $start = \Carbon\Carbon::parse($start)->addDay(1)->format('Y-m-d');
                            ?>
                            <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,'Astrazeneca',$start)) }}</td>
                            <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,'Sinovac',$start)) }}</td>
                        @endwhile
                        <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,'Astrazeneca',null)) }}</td>
                        <td class="text-center">{{ number_format(QuickCountController::countVaccinated(null,'Sinovac',null)) }}</td>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
@endsection



@section('js')
    <script>
        var down=false;
        var scrollLeft=0;
        var x = 0;

        $('.table-responsive').mousedown(function(e) {
            down = true;
            scrollLeft = this.scrollLeft;
            x = e.clientX;
        }).mouseup(function() {
            down = false;
        }).mousemove(function(e) {
            if (down) {
                this.scrollLeft = scrollLeft + x - e.clientX;
            }
        }).mouseleave(function() {
            down = false;
        });
    </script>
@endsection
