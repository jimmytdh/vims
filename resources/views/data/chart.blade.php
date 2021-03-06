<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{ route('chart') }}",
            type: "GET",
            success: function(data) {
                $("#today").html(data.today);
                $("#tomorrow").html(data.tomorrow);
                $("#v_today").html(data.v_today);
                $("#v_dosage1").html(data.v_dosage1);
                // transaction chart
                new Chart('areaChart', {
                    type: 'line',
                    data: {
                        labels: data.area.label,
                        datasets: [{
                            backgroundColor: utils.transparentize(presets.green),
                            borderColor: presets.green,
                            data: data.area.mcc,
                            label: 'MCC',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.yellow),
                            borderColor: presets.yellow,
                            data: data.area.hopss,
                            label: 'HOPSS',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.blue),
                            borderColor: presets.blue,
                            data: data.area.mpsd,
                            label: 'MPSD',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.red),
                            borderColor: presets.red,
                            data: data.area.nsd,
                            label: 'NSD',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.orange),
                            borderColor: presets.red,
                            data: data.area.fms,
                            label: 'FMS',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.purple),
                            borderColor: presets.purple,
                            data: data.area.qmd,
                            label: 'QMD',
                            fill: false
                        },]
                    }
                });
                // categorical chart
                var config = {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [
                                data.donut.vaccinated,
                                data.donut.waiting

                            ],
                            backgroundColor: [
                                window.chartColors.green,
                                window.chartColors.red,
                            ],
                            label: 'Dataset'
                        }],
                        labels: [
                            'Vaccinated',
                            'Waiting List'
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'left',
                        },
                        title: {
                            display: false,
                            text: "{{ date('F') }}"
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                };
                var ctx = document.getElementById('donutChart').getContext('2d');
                window.myDoughnut = new Chart(ctx, config);
                console.log('where');
                setTimeout(function () {
                    hideLoader();
                },500);
            },
            error: function (err) {
                console.log(err);
                setTimeout(function(){
                    $("#modalLoadError").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                },3000);
            }
        });
    });
</script>
