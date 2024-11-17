@props([
    'title' => ' ',
    'employee' => $employee,
])

<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="{{ asset('assets/images/profile-bg.jpg') }}" alt="" class="profile-wid-img" />
    </div>
</div>
<div class="pt-4 mb-4 mb-lg-0 pb-lg-4 profile-wrapper">
    <div class="row g-4">
        <div class="col-auto">
            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                <img src="{{ $employee->img ?? '' }}" alt="user-img"
                    class="rounded-circle avatar-lg img-thumbnail user-profile-image" />
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="p-2">
                <h3 class="text-white mb-1">{{ ucwords($employee->full_name) ?? '' }}</h3>
                <p class="text-white text-opacity-75 mb-2">{{ ucwords($employee->designation) ?? '' }}</p>
                <div class="hstack text-white-50 gap-1">
                    <div class="me-2"><i
                            class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>
                        {{ ucwords($employee->country) ?? '' }}
                    </div>
                    <div>
                        <i class="ri-building-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>
                        {{ ucwords($employee->department->department_name) ?? '' }}
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-12 col-lg-auto order-last order-lg-0">
            <div class="row text text-white-50 text-center">
                <div class="col-lg-6 col-4">
                    <div class="p-2">
                        <h4 class="text-white mb-1">0{{ count($employee->reportingManager) }}</h4>
                        <p class="fs-14 mb-0">Followers</p>
                    </div>
                </div>
                <div class="col-lg-6 col-4">
                    <div class="p-2">
                        <h4 class="text-white mb-1">1.3K</h4>
                        <p class="fs-14 mb-0">Following</p>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->

    </div>
    <!--end row-->
</div>
