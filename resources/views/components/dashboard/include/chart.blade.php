<div class="row">
    <div class="col-xl-12">
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
    </div>
    <div class="col-xl-12">
        <!-- card -->
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">
                    Offcie Locations
                </h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-primary btn-sm">
                        Export Report
                    </button>
                </div>
            </div>
            <!-- end card header -->

            <!-- card body -->
            <div class="card-body">
                <div id="office-locations" data-colors='["--vz-light", "--vz-success", "--vz-primary"]'
                    {{-- <div id="office-locations" data-colors='["--vz-light", "--vz-success", "--vz-primary"]' --}} style="height: 100vh" dir="ltr"></div>

                {{-- <div class="px-2 py-2 mt-1">
                    @php
                        // Define an associative array with city names and their percentages
                        $cities = [
                            'Dubai' => 75,
                            'Jeddah' => 47,
                            'Riyadh' => 82,
                            'Dammam' => 65,
                            'India' => 90,
                            // 'Bahrain' => 55,
                            'Oman' => 70,
                        ];
                    @endphp

                    @foreach ($cities as $city => $percentage)
                        <p class="mt-3 mb-1">
                            {{ $city }} <span class="float-end">{{ $percentage }}%</span>
                        </p>
                        <div class="progress mt-0" style="height: 6px">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function renderOfficeLocationsMap() {
            // Define colors directly without fetching from the DOM
            var regionFillColor = "#E9ECEF"; // Example color for regions
            var markerColor = "#007BFF"; // Example color for markers
            var selectedMarkerColor = "#28A745"; // Example color for selected markers

            // Initialize map
            document.getElementById("office-locations").innerHTML = "";
            new jsVectorMap({
                map: "world_merc",
                selector: "#office-locations", // Updated ID to "office-locations"
                zoomOnScroll: 1,
                zoomButtons: 1,
                selectedMarkers: [0, 5],
                regionStyle: {
                    initial: {
                        stroke: "#9599ad",
                        strokeWidth: .25,
                        fill: regionFillColor, // Directly use the color here
                        fillOpacity: 1
                    }
                },
                markersSelectable: !0,
                markers: [{
                        name: "Dubai",
                        coords: [25.276987, 55.296249]
                    }, // Dubai coordinates
                    {
                        name: "Jeddah",
                        coords: [21.2854, 39.2376]
                    }, // Jeddah coordinates
                    {
                        name: "Riyadh",
                        coords: [24.7136, 46.6753]
                    }, // Riyadh coordinates
                    {
                        name: "Dammam",
                        coords: [26.4207, 49.9935]
                    }, // Dammam coordinates
                    {
                        name: "India",
                        coords: [20.5937, 78.9629]
                    }, // Approximate coordinates for India
                    // {
                    //     name: "Bahrain",
                    //     coords: [26.0667, 50.5577]
                    // }, // Bahrain coordinates
                    {
                        name: "Oman",
                        coords: [21.5126, 55.9233]
                    } // Oman coordinates
                ],
                markerStyle: {
                    initial: {
                        fill: markerColor // Direct color for markers
                    },
                    selected: {
                        fill: selectedMarkerColor // Direct color for selected markers
                    }
                },
                labels: {
                    markers: {
                        render: function(e) {
                            return e.name;
                        }
                    }
                },
                // Adjust the initial zoom level here
                zoom: 2, // Adjust this value for more zoom (1 is the most zoomed out)
            });
        }

        window.onresize = function() {
            setTimeout(() => {
                renderOfficeLocationsMap();
            }, 0);
        };

        window.addEventListener("load", function() {
            renderOfficeLocationsMap();
            eodChart();
        });

        function eodChart() {

            let res = ajaxRequest(url = "{{ url('administration/employee-eod-chart') }}");

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
