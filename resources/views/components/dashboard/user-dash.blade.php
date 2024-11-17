@props([
    'data' => $data ?? [],
    'orders' => $orders ?? [],
    'lowStock' => $lowStock ?? [],
    'userLogs' => $userLogs ?? [],
])

<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <x-dashboard.include.greeting />
                <!-- end card header -->
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-xxl-2 col-md-3">
                <div class="card card-height-100">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <div id="order_summary_chart"
                            data-colors='["--vz-primary", "--vz-info", "--vz-warning", "--vz-success"]'
                            class="apex-charts" dir="ltr">
                        </div>

                        @php
                            $chartData = (array) $data;
                            $orderSummary = [
                                [
                                    'name' => 'Total Order',
                                    'symbol' => 'TO',
                                    'amount' => '10',
                                    'value' => '10',
                                    'icon' => 'btc.svg',
                                    'text_class' => 'text-successs',
                                ],
                                [
                                    'name' => 'Confirmed Orders',
                                    'symbol' => 'ETH',
                                    'amount' => 20,
                                    'value' => 20,
                                    'icon' => 'eth.svg',
                                    'text_class' => 'text-danger',
                                ],
                                [
                                    'name' => 'Shipment Created',
                                    'symbol' => 'ETH',
                                    'amount' => 30,
                                    'value' => 30,
                                    'icon' => 'eth.svg',
                                    'text_class' => 'text-primary',
                                ],

                                [
                                    'name' => 'Delivery Orders',
                                    'symbol' => 'LTC',
                                    'amount' => '56',
                                    'value' => '56',
                                    'icon' => 'ltc.svg',
                                    'text_class' => 'text-success',
                                ],
                                [
                                    'name' => 'Cancelled Orders',
                                    'symbol' => 'DASH',
                                    'amount' => 0,
                                    'value' => 0,
                                    'icon' => 'dash.svg',
                                    'text_class' => 'text-success',
                                ],
                                [
                                    'name' => 'Return Orders',
                                    'symbol' => 'DASH',
                                    'amount' => 90,
                                    'value' => 90,
                                    'icon' => 'dash.svg',
                                    'text_class' => 'text-success',
                                ],
                            ];
                        @endphp
                        <ul class="list-group list-group-flush border-dashed mb-0 mt-3 pt-2">
                            @foreach ($orderSummary as $item)
                                <li class="list-group-item px-0">
                                    <div class="d-flex">
                                        {{-- <div class="flex-shrink-0 avatar-xs">
                                            <span class="avatar-title bg-light p-1 rounded-circle">
                                                <img src="{{ URL::asset('assets/images/svg/crypto-icons/' . $item['icon']) }}"
                                                    class="img-fluid" alt="{{ $item['name'] }}">
                                            </span>
                                        </div> --}}
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-1">
                                                @if ($loop->first)
                                                    {{ $item['name'] }}
                                                @else
                                                    <i
                                                        class="mdi mdi-circle fs-10 align-middle {{ $item['text_class'] }} me-1"></i>
                                                    {{ $item['name'] }}
                                                @endif
                                            </h6>

                                        </div>
                                        <div class="flex-shrink-0 text-end">
                                            <h6 class="mb-1">
                                                {{ $item['amount'] }}</h6>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xxl-10 col-md-9 order-xxl-0s order-firsts">
                <div class="d-flex flex-column h-100">
                    <div class="h-100 row">
                        <div class="col">
                            <div class="h-100">
                                <div class="row">

                                    @php
                                        $data = [
                                            [
                                                'title' => 'Total Orders',
                                                'value' => 10,
                                                'percentage' => '+100 %',
                                                'icon' => 'bx-dollar-circle',
                                                'bgClass' => 'bg-success-subtle',
                                                'link-text' => 'View Total Orders',
                                                'link-url' => url('order/order'),
                                                'trend' => 'success',
                                            ],
                                            [
                                                'title' => 'Confirmed Orders',
                                                'value' => 12,
                                                'percentage' => '+100 %',
                                                'icon' => 'bx-shopping-bag',
                                                'bgClass' => 'bg-info-subtle',
                                                'link-text' => 'View Total Confirmed',
                                                'link-url' => url('order/confirmed-order'),
                                                'trend' => 'success',
                                            ],
                                            [
                                                'title' => 'Shipment Created',
                                                'value' => 34,
                                                'percentage' => '+29.08 %',
                                                'icon' => 'bx-user-circle',
                                                'bgClass' => 'bg-warning-subtle',
                                                'link-text' => 'View Total Confirmed',
                                                'link-url' => url('shipment/tracking'),
                                                'trend' => 'success',
                                            ],
                                            [
                                                'title' => 'Delivered Orders',
                                                'value' => 45,
                                                'percentage' => '+29.08 %',
                                                'icon' => 'bx-user-circle',
                                                'bgClass' => 'bg-warning-subtle',
                                                'link-text' => 'View Total Delivered',
                                                'link-url' => url('order/delivered-order'),
                                                'trend' => 'success',
                                            ],
                                            [
                                                'title' => 'Cancelled Orders',
                                                'value' => '0',
                                                'percentage' => '+0.00 %',
                                                'icon' => 'bx-wallet',
                                                'bgClass' => 'bg-primary-subtle',
                                                'link-text' => 'View Total Cancelled',
                                                'link-url' => '#',
                                                'trend' => 'muted',
                                            ],
                                            [
                                                'title' => 'Return Orders',
                                                'value' => 45,
                                                'percentage' => '+0.00 %',
                                                'icon' => 'bx-wallet',
                                                'bgClass' => 'bg-primary-subtle',
                                                'link-text' => 'View Total Return',
                                                'link-url' => url('order/pickup-order'),
                                                'trend' => 'muted',
                                            ],
                                        ];
                                    @endphp

                                    <div class="col-xxl-9 col-xl-9 col-lg-12 col-md-12 col-12">
                                        <div class="row">
                                            @foreach ($data as $item)
                                                <div class="col-xl-4 col-lg-6 col-md-6 mt-1 mb-2">
                                                    <div class="card card-animate mb-2 h-100">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p
                                                                        class="text-uppercase fw-medium text-muted text-truncate mb-0 fs-11">
                                                                        {{ $item['title'] }}
                                                                    </p>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <h5
                                                                        class="{{ $item['trend'] === 'danger' ? 'text-danger' : 'text-success' }} fs-14 mb-0">
                                                                        <i
                                                                            class="{{ $item['trend'] === 'danger' ? 'ri-arrow-right-down-line' : 'ri-arrow-right-up-line' }} fs-13 align-middle"></i>
                                                                        {{ $item['percentage'] }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-end justify-content-between mt-4">
                                                                <div>
                                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                                        <span class="counter-value"
                                                                            data-target="{{ $item['value'] }}">
                                                                            {{ 0 }}
                                                                        </span>
                                                                    </h4>
                                                                    @if ($item['link-url'] ?? false)
                                                                        <a href="{{ $item['link-url'] }}"
                                                                            class="text-decoration-underline1">
                                                                            {{ $item['link-text'] }}
                                                                        </a>
                                                                    @endif

                                                                </div>
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <span
                                                                        class="avatar-title {{ $item['bgClass'] }} rounded fs-3">
                                                                        <i
                                                                            class="bx {{ $item['icon'] }} text-{{ $item['trend'] }}"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="col-xxl-3 col-xl-3 col-lg-12 col-md-12 col-12">
                                        <div>
                                            <div class="card h-100 rounded-0 mb-0">

                                                <div class="card-body p-0">
                                                    <div class="px-3 py-2  align-items-center d-flex">
                                                        <h6
                                                            class="text-muted mb-0 text-uppercase fw-semibold flex-grow-1">
                                                            Recent Activity
                                                        </h6>
                                                        <div>
                                                            <a href="{{ url('administration/user-activity') }}"
                                                                class="btn btn-soft-secondary btn-sm">
                                                                View All
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div data-simplebar style="max-height: 275px;" class="p-3 pt-0">
                                                        <div class="acitivity-timeline acitivity-main">
                                                            @foreach ($userLogs as $log)
                                                                <div class="acitivity-item d-flex mt-2">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="{{ $log->img ?? '' }}" alt=""
                                                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6 class="mb-0 lh-base">
                                                                            {{ ucwords($log->user_name) ?? '' }}
                                                                        </h6>
                                                                        <p class="text-muted mb-0 fst-italsic">
                                                                            -- {{ $log->form_record_id ?? '' }}
                                                                            {!! logAction($log->log_action) ?? '' !!}
                                                                            By
                                                                            {{ ucwords($log->user_name) ?? '' }} --
                                                                        </p>

                                                                        {{-- <h5 class="fs-14 my-1 fw-normal"> <span class="badge  badge bg-danger"> Delete </span> </h5> --}}

                                                                        @php
                                                                            $logDate = date(
                                                                                'd-m-Y',
                                                                                strtotime($log->created_at),
                                                                            );
                                                                            $currentDate = date('d-m-Y');
                                                                        @endphp

                                                                        @if ($logDate == $currentDate)
                                                                            <span>Today</span>
                                                                        @else
                                                                            {{ $logDate }}
                                                                        @endif
                                                                        <small class="mb-0 text-muted">
                                                                            {{ date('H:i', strtotime($log->created_at)) }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-xxl-6 col-xl-8 col-lg-12 col-md-12 col-12 pe-0d">
                            <div class="card mb-0 card-height-100">
                                <div class="card-header my-1 border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">New Orders</h4>
                                    <div>
                                        <a href="{{ url('order/order') }}" class="btn btn-soft-secondary btn-sm">
                                            View All
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0 pb-3">
                                    <div class="team-list list-view-filter">
                                        <div class="team-list list-view-filter">
                                            @forelse ($orders as $order)
                                                <div class="card team-box">
                                                    <div class="card-body px-4 py-1">
                                                        <div class="row align-items-center team-row">
                                                            <div class="col-lg-2 col">
                                                                <div class="team-profile-img">
                                                                    <div class="avatar-sm img-thumbnail rounded-circle">
                                                                        {{-- <div class=""> --}}
                                                                        <div
                                                                            class="avatar-title bg-danger-subtle text-danger rounded-circle p-3">
                                                                            {{ Str::upper(substr($order->customer->full_name, 0, 2)) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="team-content">
                                                                        <a href="{{ route('order.show', ['order' => $order->order_id]) }}"
                                                                            class="d-block">
                                                                            <h5 class="mb-1 fs-12">Order Id</h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0 fs-12">
                                                                            {{ $order->order_id }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col">
                                                                <div class="row text-muted text-center">
                                                                    <div class="col-6 border-end border-end-dashed">
                                                                        <h5 class="mb-1 fs-12">Customer</h5>
                                                                        <p class="text-muted mb-0 fs-12">
                                                                            {{ $order->customer->full_name }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <h5 class="mb-1 fs-12">Location</h5>
                                                                        <p class="text-muted mb-0">
                                                                            {{ $order->shipping->address['city'] }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col">
                                                                <div class="row text-muted text-center">
                                                                    <div class="col-6 border-end border-end-dashed">
                                                                        <h5 class="mb-1 fs-12">Status</h5>
                                                                        <p class="badge bg-info py-1 fs-10">
                                                                            {{ ucwords(str_replace('_', ' ', $order->order_status)) }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <h5 class="mb-1 fs-12">Type</h5>
                                                                        <p class="badge bg-success py-1 fs-10">
                                                                            {{ $order->order_type }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="height: 25vh;">
                                                    <h3 class="text-uppercase text-danger fs-14">No new orders at the
                                                        moment
                                                    </h3>
                                                </div>


                                                {{-- <div class="mt-3">
                                                    <h3 class="text-uppercase text-danger">Sorry, Access Denied</h3>
                                                    <p class="text-muted mb-4">The page you are looking for Access Denied!</p>
                                                    <a href="http://localhost/oms/dashboard" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Back
                                                        to home</a>
                                                </div> --}}
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-xl-4 col-lg-12 col-md-12 col-12">
                            <div class="card mb-0 card-height-100">
                                {{-- <div data-simplebar style="height: 450px;"> --}}

                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        Low Stock Products
                                        @if (empty($lowStock))
                                            <span class="fs-11 text-danger">(Disabled)</span>
                                        @endif
                                    </h4>
                                </div>
                                <div class="card-body" data-simplebar style="height:300px;">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap">
                                            <tbody>
                                                @foreach ($lowStock as $stock)
                                                    <tr>
                                                        <td class="py-1 my-0 d-xl-none d-xxl-block text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-xs bg-light rounded p-1 me-2">
                                                                    <img src="{{ asset('assets/images/prod.png') }}"
                                                                        alt="" class="img-fluid d-block" />
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1 text-truncate truncate"
                                                                        title="{{ $stock->item ?? '' }}">
                                                                        <a href="#" class="text-reset">
                                                                            {{ $stock->item ?? '' }}
                                                                        </a>
                                                                    </h5>
                                                                    <span class="text-muted">
                                                                        {{ date('Y-m-d', strtotime($stock->updated_at)) ?? '' }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="py-1 my-0">
                                                            <h5 class="fs-14 my-1 fw-normal truncate"
                                                                style="width:95px"
                                                                title="{{ $stock->item_code ?? '' }}">
                                                                {{ $stock->item_code ?? '' }}
                                                            </h5>
                                                            <span class="text-muted">Item Code</span>
                                                        </td>
                                                        <td class="py-1 my-0">
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ $stock->unit ?? '' }}
                                                            </h5>
                                                            <span class="text-muted">Unit</span>
                                                        </td>
                                                        <td class="py-1 my-0">
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                @if ($stock->qty == 0)
                                                                    <span class="badge bg-danger-subtle text-danger">
                                                                        Out of stock
                                                                    </span>
                                                                @else
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ $stock->qty ?? '' }}
                                                                    </h5>
                                                                @endif
                                                            </h5>
                                                            <span class="text-muted">Stock</span>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    {{-- <script src="{{ asset('assets/js/pages/dashboard-crypto.init.js') }}"></script> --}}

    <script src="{{ asset('assets/js/pages/dashboard-nft.init.js') }}"></script>

    <script>
        orderSummaryChart();

        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var t = document.getElementById(e).getAttribute("data-colors");
                if (t) return (t = JSON.parse(t)).map(function(e) {
                    var t = e.replace(" ", "");
                    return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(
                        t) || t : 2 == (e = e.split(",")).length ? "rgba(" + getComputedStyle(document
                        .documentElement).getPropertyValue(e[0]) + "," + e[1] + ")" : t
                });
                console.warn("data-colors Attribute not found on:", e)
            }
        }

        function orderSummaryChart() {
            let arrValue = [
                {{ $chartData['confirmed_count'] ?? 20 }},
                {{ $chartData['created_shipment_count'] ?? 10 }},
                {{ $chartData['delivered_count'] ?? 40 }},
                0
            ]
            console.log(arrValue);


            var options = {
                series: arrValue,
                chart: {
                    // height: '100%', // Responsive height
                    // width: '110%', // Responsive width
                    type: 'donut',
                },
                labels: ['Confirmed Order', 'Shipment Created', 'Delivered Order'],
                colors: [
                    '#F06548',
                    '#405189',
                    '#0AB39C',
                ],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%' // Adjust this value to make the donut thicker
                        }
                    }
                },
                legend: {
                    show: false // Disable the legend
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300,
                        },
                        dataLabels: {
                            formatter(val, opts) {
                                const name = opts.w.globals.labels[opts.seriesIndex]
                                return [name, val.toFixed(1) + '%']
                            },
                        },
                        legend: {
                            show: false // Ensure the legend is hidden on smaller screens
                        }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#order_summary_chart"), options);
            chart.render();
        }
    </script>
@endpush
