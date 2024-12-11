<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-5 col-lg-5">
                <div class="d-flex flex-column h-100">
                    <div class="row h-100">

                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 col-xl-9">
                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <x-dashboard.include.greeting />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center"
                                        role="alert">
                                        <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                        <div class="flex-grow-1 text-truncate">
                                            Your free trial expired in <b>17</b> days.
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="pages-pricing.html"
                                                class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                        </div>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-sm-8">
                                            <div class="p-3">
                                                <p class="fs-16 lh-base">Upgrade your plan from a <span
                                                        class="fw-semibold">Free trial</span>, to ‘Premium Plan’ <i
                                                        class="mdi mdi-arrow-right"></i></p>
                                                <div class="mt-3">
                                                    <a href="pages-pricing.html" class="btn btn-success">Upgrade
                                                        Account!</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="px-3">
                                                <img src="assets/images/user-illustarator-2.png" class="img-fluid"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <div id="cards-container" class="row">
                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Users</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                    data-target="28.05">0</span>k</h2>
                                            <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i> 16.24 % </span> vs.
                                                previous month</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="users" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div> <!-- end card-->
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Sessions</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                    data-target="97.66">0</span>k</h2>
                                            <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"> <i
                                                        class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs.
                                                previous month</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="activity" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div> <!-- end card-->
                        </div>

                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Avg. Visit Duration</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                    data-target="3">0</span>m
                                                <span class="counter-value" data-target="40">0</span>sec
                                            </h2>
                                            <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"> <i
                                                        class="ri-arrow-down-line align-middle"></i> 0.24 % </span> vs.
                                                previous month</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="clock" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div> <!-- end card-->
                        </div>

                        <div class="col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Bounce Rate</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                    data-target="33.48">0</span>%</h2>
                                            <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i> 7.05 % </span> vs.
                                                previous month</p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="external-link" class="text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div> <!-- end card-->
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-xxl-7 col-lg-7">
                <div class="row h-100">
                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Live Users By Country</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        Export Report
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <!-- card body -->
                            <div class="card-body">

                                <div id="users-by-country" data-colors='["--vz-light"]' class="text-center"
                                    style="height: 252px"></div>

                                <div class="table-responsive table-card mt-3">
                                    <table
                                        class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                                        <thead
                                            class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                                            <tr>
                                                <th>Duration (Secs)</th>
                                                <th style="width: 30%;">Sessions</th>
                                                <th style="width: 30%;">Views</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            <tr>
                                                <td>0-30</td>
                                                <td>2,250</td>
                                                <td>4,250</td>
                                            </tr>
                                            <tr>
                                                <td>31-60</td>
                                                <td>1,501</td>
                                                <td>2,050</td>
                                            </tr>
                                            <tr>
                                                <td>61-120</td>
                                                <td>750</td>
                                                <td>1,600</td>
                                            </tr>
                                            <tr>
                                                <td>121-240</td>
                                                <td>540</td>
                                                <td>1,040</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Sessions by Countries</h4>
                                <div>
                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                        ALL
                                    </button>
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        1M
                                    </button>
                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                        6M
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div>
                                    <div id="countries_charts"
                                        data-colors='["--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-danger", "--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-info"]'
                                        class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div>

                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Audiences Metrics</h4>
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
                    <div class="card-header p-0 border-0 bg-light-subtle">
                        <div class="row g-0 text-center">
                            <div class="col-6 col-sm-4">
                                <div class="p-3 border border-dashed border-start-0">
                                    <h5 class="mb-1"><span class="counter-value" data-target="854">0</span>
                                        <span class="text-success ms-1 fs-12">49%<i
                                                class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                    </h5>
                                    <p class="text-muted mb-0">Avg. Session</p>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="p-3 border border-dashed border-start-0">
                                    <h5 class="mb-1"><span class="counter-value" data-target="1278">0</span>
                                        <span class="text-success ms-1 fs-12">60%<i
                                                class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                    </h5>
                                    <p class="text-muted mb-0">Conversion Rate</p>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="p-3 border border-dashed border-start-0 border-end-0">
                                    <h5 class="mb-1"><span class="counter-value" data-target="3">0</span>m
                                        <span class="counter-value" data-target="40">0</span>sec
                                        <span class="text-success ms-1 fs-12">37%<i
                                                class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                    </h5>
                                    <p class="text-muted mb-0">Avg. Session Duration</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-2">
                        <div>
                            <div id="audiences_metrics_charts" data-colors='["--vz-success", "--vz-light"]'
                                class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Audiences Sessions by Country</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="fw-semibold text-uppercase fs-12">Sort by: </span><span
                                        class="text-muted">Current Week<i
                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Current Year</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div>
                            <div id="audiences-sessions-country-charts" data-colors='["--vz-success", "--vz-info"]'
                                class="apex-charts" dir="ltr"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


        <div class="row">
            <div class="col-xl-12">
                <x-dashboard.include.eod-reporting-chart />
            </div>
        </div>


        <div class="row">
            <div class="col-xl-4">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Users by Device</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted fs-16"><i
                                            class="mdi mdi-dots-vertical align-middle"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Current Year</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="user_device_pie_charts" data-colors='["--vz-primary", "--vz-warning", "--vz-info"]'
                            class="apex-charts" dir="ltr"></div>

                        <div class="table-responsive mt-3">
                            <table
                                class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                                <tbody class="border-0">
                                    <tr>
                                        <td>
                                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                    class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop
                                                Users</h4>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0"><i data-feather="users"
                                                    class="me-2 icon-sm"></i>78.56k</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="text-success fw-medium fs-12 mb-0"><i
                                                    class="ri-arrow-up-s-fill fs-5 align-middle"></i>2.08% </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                    class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Mobile
                                                Users</h4>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0"><i data-feather="users"
                                                    class="me-2 icon-sm"></i>105.02k</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="text-danger fw-medium fs-12 mb-0"><i
                                                    class="ri-arrow-down-s-fill fs-5 align-middle"></i>10.52%
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                    class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Tablet
                                                Users</h4>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0"><i data-feather="users"
                                                    class="me-2 icon-sm"></i>42.89k</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="text-danger fw-medium fs-12 mb-0"><i
                                                    class="ri-arrow-down-s-fill fs-5 align-middle"></i>7.36%
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Top Referrals Pages</h4>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-soft-primary btn-sm">
                                Export Report
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row align-items-center">
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">Total
                                    Referrals Page</h6>
                                <h4 class="mb-0">725,800</h4>
                                <p class="mb-0 mt-2 text-muted"><span
                                        class="badge bg-success-subtle text-success mb-0"> <i
                                            class="ri-arrow-up-line align-middle"></i> 15.72 % </span> vs. previous
                                    month</p>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <img src="assets/images/illustrator-1.png" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-2">
                            <div class="progress progress-lg rounded-pill">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 25%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 18%"
                                    aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 22%"
                                    aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 16%"
                                    aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 19%"
                                    aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mt-3 pt-2">
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0"><i
                                            class="mdi mdi-circle align-middle text-primary me-2"></i>www.google.com
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">24.58%</p>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0"><i
                                            class="mdi mdi-circle align-middle text-info me-2"></i>www.youtube.com </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">17.51%</p>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0"><i
                                            class="mdi mdi-circle align-middle text-success me-2"></i>www.meta.com </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">23.05%</p>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0"><i
                                            class="mdi mdi-circle align-middle text-warning me-2"></i>www.medium.com
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">12.22%</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-muted fs-14 mb-0"><i
                                            class="mdi mdi-circle align-middle text-danger me-2"></i>Other </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0">17.58%</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 text-center">
                            <a href="javascript:void(0);" class="text-muted text-decoration-underline">Show All</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h6 class="text-muted mb-0 text-uppercase fw-semibold flex-grow-1">
                            Recent Activity
                        </h6>
                        <div>
                            <a href="{{ url('administration/user-activity') }}" class="btn btn-soft-secondary btn-sm">
                                View All
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- <x-dashboard.include.user-activity :userLogs="$userLogs" :isEmployeeDashboard="false" /> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/pages/dashboard-analytics.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            fetchCardData();
        });

        // Fetch card data
        function fetchCardData() {
            $.ajax({
                url: "{{ url('get-cards') }}",
                method: 'GET',
                success: function(data) {
                    renderCards(data);
                    initializeKpiCountAnimation();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cards:', error);
                }
            });
        }

        // Render card HTML
        function renderCards(data) {
            let cardsHtml = '';
            data.forEach(card => {
                cardsHtml += generateCardHtml(card);
            });
            $('#cards-container').html(cardsHtml);
        }

        // Generate individual card HTML
        function generateCardHtml(card) {
            return `
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">${card.title}</p>
                                   <h2 class="mt-4 ff-secondary fw-semibold">
                                    <span class="counter-value" data-target="${card.value}"> 0 </span>
                                    </h2>
                                    <a class="mb-0 text-muted text-decoration-underline">
                                           ${card.title}
                                    </a>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i class="${card.icon} ${card.iconColor}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div>
                `;
        }


        // Initialize KPI count animation
        function initializeKpiCountAnimation() {
            const counters = document.querySelectorAll(".counter-value");

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            counters.forEach(counter => {
                animateCounter(counter);
            });

            function animateCounter(counter) {
                const target = +counter.getAttribute("data-target");
                let current = +counter.innerText;
                const increment = target / 250;

                function updateCounter() {
                    current = Math.min(current + increment, target);
                    counter.innerText = formatNumber(Math.floor(current));
                    if (current < target) {
                        setTimeout(updateCounter, 1);
                    } else {
                        counter.innerText = formatNumber(target);
                    }
                }

                updateCounter();
            }
        }
    </script>
@endpush
