<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{ route('chart') }}",
            type: "GET",
            success: function(data) {
                console.log(data.donut);

                // transaction chart
                new Chart('areaChart', {
                    type: 'line',
                    data: {
                        labels: data.area.label,
                        datasets: [{
                            backgroundColor: utils.transparentize(presets.green),
                            borderColor: presets.green,
                            data: data.area.early,
                            label: 'Early Pregnancy',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.yellow),
                            borderColor: presets.yellow,
                            data: data.area.sono,
                            label: 'Sonographic Findings',
                            fill: false
                        },{
                            backgroundColor: utils.transparentize(presets.blue),
                            borderColor: presets.blue,
                            data: data.area.tri,
                            label: '2nd and 3rd Trimester',
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
                                data.donut.early,
                                data.donut.sono,
                                data.donut.tri

                            ],
                            backgroundColor: [
                                window.chartColors.green,
                                window.chartColors.yellow,
                                window.chartColors.blue
                            ],
                            label: 'Dataset 1'
                        }],
                        labels: [
                            'Early Pregnancy',
                            'Sonographic Findings',
                            '2nd and 3rd Trimester',
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

                setTimeout(function () {
                    $("#loader-wrapper").css('visibility','hidden');
                },1000);
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
