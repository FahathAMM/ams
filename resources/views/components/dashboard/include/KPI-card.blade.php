@props([
    'userLogs' => $userLogs,
])

@php
    $cards = [
        [
            'title' => 'Total Earnings',
            'percentage' => '+16.24 %',
            'percentageClass' => 'text-success',
            'icon' => 'bx-dollar-circle',
            'iconBg' => 'bg-success-subtle',
            'iconColor' => 'text-success',
            'value' => '559.25',
            'valueSuffix' => 'k',
            'link' => 'View net earnings',
            'linkUrl' => '#',
        ],
        [
            'title' => 'Orders',
            'percentage' => '-3.57 %',
            'percentageClass' => 'text-danger',
            'icon' => 'bx-shopping-bag',
            'iconBg' => 'bg-info-subtle',
            'iconColor' => 'text-info',
            'value' => '36894',
            'valueSuffix' => '',
            'link' => 'View all orders',
            'linkUrl' => '#',
        ],
        [
            'title' => 'Customers',
            'percentage' => '+29.08 %',
            'percentageClass' => 'text-success',
            'icon' => 'bx-user-circle',
            'iconBg' => 'bg-warning-subtle',
            'iconColor' => 'text-warning',
            'value' => '183.35',
            'valueSuffix' => 'M',
            'link' => 'See details',
            'linkUrl' => '#',
        ],
        [
            'title' => 'My Balance',
            'percentage' => '+0.00 %',
            'percentageClass' => 'text-muted',
            'icon' => 'bx-wallet',
            'iconBg' => 'bg-primary-subtle',
            'iconColor' => 'text-primary',
            'value' => '165.89',
            'valueSuffix' => 'k',
            'link' => 'Withdraw money',
            'linkUrl' => '#',
        ],
    ];
@endphp

<div class="row">
    @foreach ($cards as $card)
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                {{ $card['title'] }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="{{ $card['percentageClass'] }} fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                {{ $card['percentage'] }}
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                $<span class="counter-value"
                                    data-target="{{ $card['value'] }}">0</span>{{ $card['valueSuffix'] }}
                            </h4>
                            <a href="{{ $card['linkUrl'] }}" class="text-decoration-underline">{{ $card['link'] }}</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title {{ $card['iconBg'] }} rounded fs-3">
                                <i class="{{ $card['icon'] }} {{ $card['iconColor'] }}"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    @endforeach
</div>
