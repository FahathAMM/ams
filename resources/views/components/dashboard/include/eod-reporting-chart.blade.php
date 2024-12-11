<div class="card card-height-100">
    <div class="card-header pt-2 pb-0 my-0 border-0 align-items-center d-flex">
        <h6 class="card-title mb-0 flex-grow-1">EOD Report</h6>
    </div>
    <div class="card-body p-0 pb-2">
        <div class="w-100">
            <div id="chart" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts"
                dir="ltr"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener("load", function() {
            eodChart();
        });

        function eodChart() {

            let res = ajaxRequest(url = "{{ url('administration/employee-eod-chart') }}");

            if (!res.status) {
                return;
            }

            console.log('res ', res);

            var options = {
                series: res.series,
                chart: {
                    type: 'bar',
                    height: 450,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'last',
                        dataLabels: {
                            total: {
                                enabled: false,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 90
                                }
                            }
                        }
                    }
                },
                xaxis: {
                    type: 'date',
                    categories: res.months,
                },
                legend: {
                    position: 'right',
                    offsetY: 40
                },
                fill: {
                    opacity: 1
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#F3F3F9']
                    },
                    formatter: function(val, opts) {
                        // Get the series name for the current data point
                        let seriesName = opts.w.config.series[opts.seriesIndex].name;
                        return seriesName + ": " + val; // Format as "Series Name: Value"
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        }
    </script>
@endpush
