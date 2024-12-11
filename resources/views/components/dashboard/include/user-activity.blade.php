@props([
    'userLogs' => $userLogs,
    'isEmployeeDashboard' => $isEmployeeDashboard ?? false,
])

@if ($isEmployeeDashboard)
    <div class="px-3 py-2  align-items-center d-flex">
        <h6 class="text-muted mb-0 text-uppercase fw-semibold flex-grow-1">
            Recent Activity
        </h6>
        <div>
            <a href="{{ url('administration/user-activity') }}" class="btn btn-soft-secondary btn-sm">
                View All
            </a>
        </div>
    </div>
@endif

<div data-simplebar style="max-height: 275px;" class="p-3 pt-0">
    <div class="acitivity-timeline acitivity-main">
        @foreach ($userLogs as $log)
            <div class="acitivity-item d-flex mt-2">
                <div class="flex-shrink-0">
                    <img src="{{ $log->img ?? '' }}" alt="" class="avatar-xs rounded-circle acitivity-avatar" />
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-0 lh-base">
                        {{ ucwords($log->user_name) ?? '' }}
                    </h6>
                    <p class="text-muted mb-0 fst-italsic fs-11">
                        {{ $log->form_record_id ?? '' }} {!! logAction($log->log_action) ?? '' !!} By {{ ucwords($log->user_name) ?? '' }}
                    </p>

                    {{-- <h5 class="fs-14 my-1 fw-normal"> <span class="badge  badge bg-danger"> Delete </span> </h5> --}}

                    @php
                        $logDate = date('d-m-Y', strtotime($log->created_at));
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

@if ($isEmployeeDashboard)
    <section>
        <div class="p-3 mt-2">
            <hr style="border-color: #777a88;">
            <h6 class="text-muted mb-3 text-uppercase fw-semibold">
                Top 10 Categories
            </h6>

            <ol class="ps-3 text-muted">
                <li class="py-1">
                    <a href="#" class="text-muted">Mobile & Accessories
                        <span class="float-end">(10,294)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Desktop <span class="float-end">(6,256)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Electronics
                        <span class="float-end">(3,479)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Home & Furniture
                        <span class="float-end">(2,275)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Grocery <span class="float-end">(1,950)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Fashion <span class="float-end">(1,582)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Appliances
                        <span class="float-end">(1,037)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Beauty, Toys & More
                        <span class="float-end">(924)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Food & Drinks
                        <span class="float-end">(701)</span></a>
                </li>
                <li class="py-1">
                    <a href="#" class="text-muted">Toys & Games
                        <span class="float-end">(239)</span></a>
                </li>
            </ol>
            <div class="mt-3 text-center">
                <a href="javascript:void(0);" class="text-muted text-decoration-underline">View
                    all Categories</a>
            </div>
        </div>
        <div class="p-3">
            <h6 class="text-muted mb-3 text-uppercase fw-semibold">
                Products Reviews
            </h6>
            <div class="swiper vertical-swiper" style="height: 250px">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card border border-dashed shadow-none">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light rounded">
                                            <img src="assets/images/companies/img-1.png" alt=""
                                                height="30" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div>
                                            <p class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                " Great product and looks great, lots
                                                of features. "
                                            </p>
                                            <div class="fs-11 align-middle text-warning">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                            </div>
                                        </div>
                                        <div class="text-end mb-0 text-muted">
                                            - by
                                            <cite title="Source Title">Force Medicines</cite>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card border border-dashed shadow-none">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/users/avatar-3.jpg" alt=""
                                            class="avatar-sm rounded" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div>
                                            <p class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                " Amazing template, very easy to
                                                understand and manipulate. "
                                            </p>
                                            <div class="fs-11 align-middle text-warning">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-half-fill"></i>
                                            </div>
                                        </div>
                                        <div class="text-end mb-0 text-muted">
                                            - by
                                            <cite title="Source Title">Henry Baird</cite>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card border border-dashed shadow-none">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light rounded">
                                            <img src="assets/images/companies/img-8.png" alt=""
                                                height="30" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div>
                                            <p class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                "Very beautiful product and Very
                                                helpful customer service."
                                            </p>
                                            <div class="fs-11 align-middle text-warning">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-line"></i>
                                                <i class="ri-star-line"></i>
                                            </div>
                                        </div>
                                        <div class="text-end mb-0 text-muted">
                                            - by
                                            <cite title="Source Title">Zoetic Fashion</cite>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card border border-dashed shadow-none">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/users/avatar-2.jpg" alt=""
                                            class="avatar-sm rounded" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div>
                                            <p class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                " The product is very beautiful. I
                                                like it. "
                                            </p>
                                            <div class="fs-11 align-middle text-warning">
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-half-fill"></i>
                                                <i class="ri-star-line"></i>
                                            </div>
                                        </div>
                                        <div class="text-end mb-0 text-muted">
                                            - by
                                            <cite title="Source Title">Nancy Martino</cite>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3">
            <h6 class="text-muted mb-3 text-uppercase fw-semibold">
                Customer Reviews
            </h6>
            <div class="bg-light px-3 py-2 rounded-2 mb-2">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="fs-16 align-middle text-warning">
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-half-fill"></i>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <h6 class="mb-0">4.5 out of 5</h6>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-muted">
                    Total <span class="fw-medium">5.50k</span> reviews
                </div>
            </div>

            <div class="mt-3">
                <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0">5 star</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-1">
                            <div class="progress animated-progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50.16%"
                                    aria-valuenow="50.16" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0 text-muted">2758</h6>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0">4 star</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-1">
                            <div class="progress animated-progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 29.32%"
                                    aria-valuenow="29.32" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0 text-muted">1063</h6>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0">3 star</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-1">
                            <div class="progress animated-progress progress-sm">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 18.12%"
                                    aria-valuenow="18.12" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0 text-muted">997</h6>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0">2 star</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-1">
                            <div class="progress animated-progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 4.98%"
                                    aria-valuenow="4.98" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0 text-muted">227</h6>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0">1 star</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-1">
                            <div class="progress animated-progress progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 7.42%"
                                    aria-valuenow="7.42" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="p-1">
                            <h6 class="mb-0 text-muted">408</h6>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>

        <div class="card sidebar-alert bg-light border-0 text-center mx-4 mb-0 mt-3">
            <div class="card-body">
                <div class="mt-4">
                    <h5>Invite New Seller</h5>
                    <p class="text-muted lh-base">
                        Refer a new seller to us and earn $100 per refer.
                    </p>
                    <button type="button" class="btn btn-primary btn-label rounded-pill">
                        <i class="ri-mail-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                        Invite Now
                    </button>
                </div>
            </div>
        </div>
    </section>
@endif
