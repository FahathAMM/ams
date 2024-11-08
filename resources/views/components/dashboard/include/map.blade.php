@props([
    'userLogs' => $userLogs,
])
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Revenue</h4>
                <div>
                    <button type="button" class="btn btn-soft-secondary btn-sm">
                        ALL
                    </button>
                    <button type="button" class="btn btn-soft-secondary btn-sm">
                        1M
                    </button>
                    <button type="button" class="btn btn-soft-secondary btn-sm">
                        6M
                    </button>
                    <button type="button" class="btn btn-soft-primary btn-sm">
                        1Y
                    </button>
                </div>
            </div>
            <!-- end card header -->

            <div class="card-header p-0 border-0 bg-light-subtle">
                <div class="row g-0 text-center">
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">
                                <span class="counter-value" data-target="7585">0</span>
                            </h5>
                            <p class="text-muted mb-0">Orders</p>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">
                                $<span class="counter-value" data-target="22.89">0</span>k
                            </h5>
                            <p class="text-muted mb-0">Earnings</p>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">
                                <span class="counter-value" data-target="367">0</span>
                            </h5>
                            <p class="text-muted mb-0">Refunds</p>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                            <h5 class="mb-1 text-success">
                                <span class="counter-value" data-target="18.92">0</span>%
                            </h5>
                            <p class="text-muted mb-0">
                                Conversation Ratio
                            </p>
                        </div>
                    </div>
                    <!--end col-->
                </div>
            </div>
            <!-- end card header -->

            <div class="card-body p-0 pb-2">
                <div class="w-100">
                    <div id="customer_impression_charts" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]'
                        class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-4">
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
                    {{-- <div id="office-locations" data-colors='["--vz-light", "--vz-success", "--vz-primary"]' --}} style="height: 269px" dir="ltr"></div>

                <div class="px-2 py-2 mt-1">
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
                </div>

            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
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
        });
    </script>
@endpush
