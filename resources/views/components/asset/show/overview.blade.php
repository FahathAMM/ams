@props([
    'title' => ' ',
    'employee' => $employee,
])

@php
    $basicInfo = [
        'Full Name' => ucwords($employee->full_name) ?? '---',
        'Mobile' => $employee->phone_number ?? '---',
        'E-mail' => $employee->email ?? '---',
        'Country' => ucwords($employee->country) ?? '---',
        'Joining Date' => date('d M Y', strtotime($employee->joining_date)) ?? '---',
    ];
@endphp

<div class="row">
    <div class="col-xxl-3 col-xl-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5">Complete Your Profile</h5>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="label">30%</div>
                    </div>
                </div>
            </div>
        </div>
        <x-card.grid-card titleName="Basic Info">
            <div class="vstack gap-1">
                @foreach ($basicInfo as $key => $info)
                    @if (!is_null($info))
                        <div class="d-flex align-items-center border-bottom">
                            <div class="flex-grow-1s w-50">
                                <h5 class="fs-13 mb-0">
                                    <label class="text-body d-block mb-1 fs-12">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                </h5>
                            </div>
                            <div class="flex-shrink-0 text-start">
                                <div class="d-flex align-items-center gap-1">
                                    <label class="mb-1 fw-normal fs-11">{{ $info }}</label>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </x-card.grid-card>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Portfolio</h5>
                <div class="d-flex flex-wrap gap-2">
                    <div>
                        <a href="javascript:void(0);" class="avatar-xs d-block">
                            <span class="avatar-title rounded-circle fs-16 bg-body text-body">
                                <i class="ri-github-fill"></i>
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="avatar-xs d-block">
                            <span class="avatar-title rounded-circle fs-16 bg-primary">
                                <i class="ri-global-fill"></i>
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="avatar-xs d-block">
                            <span class="avatar-title rounded-circle fs-16 bg-success">
                                <i class="ri-dribbble-fill"></i>
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="avatar-xs d-block">
                            <span class="avatar-title rounded-circle fs-16 bg-danger">
                                <i class="ri-pinterest-fill"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Skills</h5>
                <div class="d-flex flex-wrap gap-2 fs-15">
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Photoshop</a>
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">illustrator</a>
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">HTML</a>
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">CSS</a>
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Javascript</a>
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Php</a>
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Python</a>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->

        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Suggestions</h5>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill fs-14"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center py-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <img src="{{ asset('assets/images/users/avatar-3.jpg') }}" alt=""
                                class="img-fluid rounded-circle" />
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                <h5 class="fs-14 mb-1">Esther James</h5>
                                <p class="fs-13 text-muted mb-0">Frontend Developer</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <button type="button" class="btn btn-sm btn-outline-success"><i
                                    class="ri-user-add-line align-middle"></i></button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center py-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <img src="{{ asset('assets/images/users/avatar-4.jpg') }}" alt=""
                                class="img-fluid rounded-circle" />
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                <h5 class="fs-14 mb-1">Jacqueline Steve</h5>
                                <p class="fs-13 text-muted mb-0">UI/UX Designer</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <button type="button" class="btn btn-sm btn-outline-success"><i
                                    class="ri-user-add-line align-middle"></i></button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center py-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <img src="{{ asset('assets/images/users/avatar-5.jpg') }}" alt=""
                                class="img-fluid rounded-circle" />
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                <h5 class="fs-14 mb-1">George Whalen</h5>
                                <p class="fs-13 text-muted mb-0">Backend Developer</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <button type="button" class="btn btn-sm btn-outline-success"><i
                                    class="ri-user-add-line align-middle"></i></button>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
        <!--end card-->

        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Popular Posts</h5>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <a href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill fs-14"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink1">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item" href="#">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('assets/images/small/img-4.jpg') }}" alt="" height="50"
                            class="rounded" />
                    </div>
                    <div class="flex-grow-1 ms-3 overflow-hidden">
                        <a href="javascript:void(0);">
                            <h6 class="text-truncate fs-14">
                                Design your apps in your own way
                            </h6>
                        </a>
                        <p class="text-muted mb-0">15 Dec 2021</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('assets/images/small/img-5.jpg') }}" alt="" height="50"
                            class="rounded" />
                    </div>
                    <div class="flex-grow-1 ms-3 overflow-hidden">
                        <a href="javascript:void(0);">
                            <h6 class="text-truncate fs-14">
                                Smartest Applications for Business
                            </h6>
                        </a>
                        <p class="text-muted mb-0">28 Nov 2021</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('assets/images/small/img-6.jpg') }}" alt="" height="50"
                            class="rounded" />
                    </div>
                    <div class="flex-grow-1 ms-3 overflow-hidden">
                        <a href="javascript:void(0);">
                            <h6 class="text-truncate fs-14">How to get creative in your
                                work</h6>
                        </a>
                        <p class="text-muted mb-0">21 Nov 2021</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-9 col-xl-9 col-lg-9">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">About</h5>
                <label class="fs-11">

                    Hello <b>{{ $employee->first_name }}</b>,

                    We want to take a moment to recognize your dedication and hard work as a valuable member of our
                    team. Since joining us on <b>{{ $employee->joining_date }}</b>, your contributions as a
                    <b>{{ $employee->designation }}</b> have not gone unnoticed.

                    Your commitment to excellence and collaboration, especially in our
                    <b>{{ $employee->department->department_name }}</b> Department at the
                    <b>{{ $employee->branch->branch_name }}</b>
                    Branch, truly makes a difference. We're grateful for your efforts and the positive energy you bring
                    to our projects.
                    <br><br>
                    We hope you will continue with us, gaining more knowledge and experience, and further enhancing our
                    team. Your growth is essential to us, and we’re excited to support you on this journey.

                    If you ever need assistance or have ideas to share, please don’t hesitate to reach out. Together,
                    let’s continue to achieve great things!

                    Best regards,
                    The Management Team

                </label>

                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class="d-flex mt-4">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="ri-user-2-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1 fs-11">Designation :</p>
                                <h6 class="text-truncate mb-0 fw-semibold">
                                    {{ ucwords($employee->designation) ?? '' }}
                                    {{-- Lead Designer / Developer --}}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-6 col-md-4">
                        <div class="d-flex mt-4">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="ri-building-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1 fs-11">Department :</p>
                                <h6 class="fw-semibold">{{ ucwords($employee->department->department_name) ?? '' }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Leave Status</h4>
                        <div class="flex-shrink-0">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">Allowed</th>
                                        <th scope="col">Available</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($employee->getFilteredLeaveBalance() as $key => $balance)
                                        <tr>
                                            <td class="d-flex">
                                                <div>
                                                    <h5 class="fs-13 mb-0">{{ $balance->name ?? '' }}</h5>
                                                    <p class="fs-12 mb-0 text-muted">{{ $balance->description ?? '' }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{{ $balance->number_of_days ?? '' }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{{ $balance->remaining_days ?? '' }}</h6>
                                            </td>
                                            <td style="width:5%;">
                                                <div id="chart-{{ $key }}" data-chart-type="radialBar"
                                                    data-value="{{ $balance->remaining_percentage }}"
                                                    data-colors='["#f46a6a"]'>
                                                </div>

                                                {{-- <div id="chart-2" data-chart-type="radialBar" data-value="50"
                                            data-colors='["#34c38f"]'>
                                        </div>

                                        <div id="chart-3" data-chart-type="radialBar" data-value="30"
                                            data-colors='["#ffcc00"]'>
                                        </div> --}}
                                                @auth

                                                @endauth
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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Projects</h5>
                <!-- Swiper -->
                <div class="swiper project-swiper mt-n4">
                    <div class="d-flex justify-content-end gap-2 mb-2">
                        <div class="slider-button-prev">
                            <div class="avatar-title fs-18 rounded px-1">
                                <i class="ri-arrow-left-s-line"></i>
                            </div>
                        </div>
                        <div class="slider-button-next">
                            <div class="avatar-title fs-18 rounded px-1">
                                <i class="ri-arrow-right-s-line"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card profile-project-card shadow-none profile-project-success mb-0">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-muted overflow-hidden">
                                            <h5 class="fs-14 text-truncate mb-1">
                                                <a href="#" class="text-body">ABC
                                                    Project Customization</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0"> Last
                                                Update : <span class="fw-semibold text-body">4 hr
                                                    Ago</span></p>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="badge bg-warning-subtle text-warning fs-10">
                                                Inprogress</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <h5 class="fs-12 text-muted mb-0">
                                                        Members :</h5>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <div
                                                                class="avatar-title rounded-circle bg-light text-primary">
                                                                A
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end slide item -->
                        <div class="swiper-slide">
                            <div class="card profile-project-card shadow-none profile-project-danger mb-0">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-muted overflow-hidden">
                                            <h5 class="fs-14 text-truncate mb-1">
                                                <a href="#" class="text-body">Client
                                                    - John</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0"> Last
                                                Update : <span class="fw-semibold text-body">1 hr
                                                    Ago</span></p>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="badge bg-success-subtle text-success fs-10">
                                                Completed</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <h5 class="fs-12 text-muted mb-0">
                                                        Members :</h5>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <div
                                                                class="avatar-title rounded-circle bg-light text-primary">
                                                                C
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end slide item -->
                        <div class="swiper-slide">
                            <div class="card profile-project-card shadow-none profile-project-info mb-0">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-muted overflow-hidden">
                                            <h5 class="fs-14 text-truncate mb-1">
                                                <a href="#" class="text-body">Brand
                                                    logo Design</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0">Last
                                                Update : <span class="fw-semibold text-body">2 hr
                                                    Ago</span></p>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="badge bg-warning-subtle text-warning fs-10">
                                                Inprogress</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <h5 class="fs-12 text-muted mb-0">
                                                        Members :</h5>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end slide item -->
                        <div class="swiper-slide">
                            <div class="card profile-project-card shadow-none profile-project-danger mb-0">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-muted overflow-hidden">
                                            <h5 class="fs-14 text-truncate mb-1">
                                                <a href="#" class="text-body">Project update</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0"> Last
                                                Update : <span class="fw-semibold text-body">4 hr
                                                    Ago</span></p>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="badge bg-success-subtle text-success fs-10">
                                                Completed</div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-4">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <h5 class="fs-12 text-muted mb-0">
                                                        Members :</h5>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end slide item -->
                        <div class="swiper-slide">
                            <div class="card profile-project-card shadow-none profile-project-warning mb-0">
                                <div class="card-body p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-muted overflow-hidden">
                                            <h5 class="fs-14 text-truncate mb-1">
                                                <a href="#" class="text-body">Chat
                                                    App</a>
                                            </h5>
                                            <p class="text-muted text-truncate mb-0"> Last
                                                Update : <span class="fw-semibold text-body">1 hr
                                                    Ago</span></p>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="badge bg-warning-subtle text-warning fs-10">
                                                Inprogress</div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-4">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div>
                                                    <h5 class="fs-12 text-muted mb-0">
                                                        Members :</h5>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <img src="{{ asset('assets/images/users/avatar-5.jpg') }}"
                                                                alt="" class="rounded-circle img-fluid" />
                                                        </div>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <div class="avatar-xs">
                                                            <div
                                                                class="avatar-title rounded-circle bg-light text-primary">
                                                                A
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end slide item -->
                    </div>

                </div>

            </div>
            <!-- end card body -->
        </div>
    </div>
</div>

@push('scripts')
    {{-- <script src="{{ asset('assets/js/pages/dashboard-projects.init.js') }}"></script> --}}

    <script>
        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var t = document.getElementById(e).getAttribute("data-colors");
                if (t) return (t = JSON.parse(t)).map(function(e) {
                    var t = e.replace(" ", "");
                    return -1 === t.indexOf(",") ?
                        getComputedStyle(document.documentElement).getPropertyValue(t) || t :
                        2 == (e = e.split(",")).length ?
                        "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[
                            1] + ")" :
                        t;
                });
                console.warn("data-colors Attribute not found on:", e);
            }
        }

        // Query all elements that will contain radialBar charts
        var radialBarChartElements = document.querySelectorAll("[data-chart-type='radialBar']");

        radialBarChartElements.forEach(function(chartElement) {
            // Get the ID and colors for each chart
            var chartId = chartElement.id;
            var series = document.getElementById(chartId).getAttribute("data-value");
            console.log('chartId', chartId);
            console.log('series', series);

            var chartColors = getChartColorsArray(chartId);

            if (chartColors) {
                // Define options for each radialBar chart
                var radialBarOptions = {
                    series: [series], // Random data for demonstration
                    chart: {
                        type: "radialBar",
                        width: 50,
                        height: 50,
                        sparkline: {
                            enabled: !0
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: "50%"
                            },
                            track: {
                                margin: 1
                            },
                            dataLabels: {
                                show: false,
                                name: {
                                    fontSize: '16px'
                                },
                                value: {
                                    fontSize: '14px'
                                }
                            }
                        }
                    },
                    colors: chartColors
                };

                // Render the chart
                var chart = new ApexCharts(document.querySelector("#" + chartId), radialBarOptions);
                chart.render();
            }
        });
    </script>
@endpush
