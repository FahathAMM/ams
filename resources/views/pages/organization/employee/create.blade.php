@extends('layout.app')
@section('title', $titleName)
@section('content')
    @push('styles')
    @endpush



    <div class="page-content">
        <div class="container-fluid">
            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="{{ asset('/assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="" />
                    <div class="overlay-content">
                        <div class="text-end p-3">
                            <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                <input id="profile-foreground-img-file-input" type="file"
                                    class="profile-foreground-img-file-input" />
                                <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                    <i class="ri-image-edit-line align-bottom me-1"></i>
                                    Change Cover
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('employee.store') }}" id="employee-form" method="POST" class="tablelist-form"
                autocomplete="off">
                @csrf
                <div class="row">

                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                        <img src="https://hancockogundiyapartners.com/wp-content/uploads/2019/07/dummy-profile-pic-300x300.jpg"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                            alt="user-profile-image" />
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" name="img" type="file"
                                                class="profile-img-file-input" />
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <h5 class="fs-12 mb-1">Select user Profile</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-5">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-0">Complete Your Profile</h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i
                                                class="ri-edit-box-line align-bottom me-1"></i>
                                            Edit</a>
                                    </div>
                                </div>
                                <div class="progress animated-progress custom-progress progress-label">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 30%"
                                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                        <div class="label">30%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Repoting Manager</h5>
                            </div>
                            <!-- end card body -->
                            <div class="card-body">
                                <div>
                                    <x-input.select-group label="Employees" name="report_manager_id" itemText="full_name"
                                        itemValue="id" :items="$employees" data-choices-search-true />
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-0">Portfolio</h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i
                                                class="ri-add-fill align-bottom me-1"></i> Add</a>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex">
                                    <div class="avatar-xs d-block flex-shrink-0 me-3">
                                        <span class="avatar-title rounded-circle fs-16 bg-body text-body">
                                            <i class="ri-github-fill"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" id="gitUsername" placeholder="Username"
                                        value="@daveadame" />
                                </div>
                                <div class="mb-3 d-flex">
                                    <div class="avatar-xs d-block flex-shrink-0 me-3">
                                        <span class="avatar-title rounded-circle fs-16 bg-primary">
                                            <i class="ri-global-fill"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="websiteInput"
                                        placeholder="www.example.com" value="www.velzon.com" />
                                </div>
                                <div class="mb-3 d-flex">
                                    <div class="avatar-xs d-block flex-shrink-0 me-3">
                                        <span class="avatar-title rounded-circle fs-16 bg-success">
                                            <i class="ri-dribbble-fill"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="dribbleName" placeholder="Username"
                                        value="@dave_adame" />
                                </div>
                                <div class="d-flex">
                                    <div class="avatar-xs d-block flex-shrink-0 me-3">
                                        <span class="avatar-title rounded-circle fs-16 bg-danger">
                                            <i class="ri-pinterest-fill"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="pinterestName" placeholder="Username"
                                        value="Advance Dave" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            role="tab">
                                            <i class="fas fa-home"></i> Personal Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i> Security
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- <form action="{{ route('employee.store') }}" id="employee-form" method="POST"
                            class="tablelist-form" autocomplete="off">
                            @csrf --}}

                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                                        @csrf
                                        <div class="row">
                                            {{-- <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Title" name="title" itemText="name"
                                                        itemValue="value" :items="$title" data-choices-search-false
                                                        value="Mr." />
                                                </div>
                                            </div> --}}
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="First Name" name="first_name"
                                                        placeholder="Enter your first name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Last Name" name="last_name"
                                                        placeholder="Enter your last name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Employee ID" name="emp_number"
                                                        placeholder="Enter employee ID" type="number" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Designation" name="designation"
                                                        placeholder="Enter your designation" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Phone Number" name="phone_number"
                                                        placeholder="Enter your phone number" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group type="email" label="Email Address"
                                                        name="email" placeholder="Enter your email" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Branch" name="branch_id"
                                                        itemText="branch_name" itemValue="id" :items="$branches"
                                                        data-choices-search-false />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Department" name="department_id"
                                                        itemText="department_name" itemValue="id" :items="$departments"
                                                        data-choices-search-false />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.date-group label="Joining Date" name="joining_date"
                                                        placeholder="Select date" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Country" name="country" itemText="name"
                                                        itemValue="value" :items="$countries" data-choices-search-true />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Gender" name="gender" itemText="name"
                                                        itemValue="value" :items="[
                                                            ['name' => 'Male', 'value' => '1'],
                                                            ['name' => 'Female', 'value' => '2'],
                                                        ]" data-choices-search-false
                                                        value="1" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Status" name="is_active" itemText="name"
                                                        itemValue="value" :items="[
                                                            ['name' => 'Active', 'value' => '1'],
                                                            ['name' => 'Deactive', 'value' => '0'],
                                                        ]" data-choices-search-false
                                                        value="1" />
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <x-input.txtarea-group label="Description" name="description"
                                                        placeholder="Enter your description" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <div class="row g-2">
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.select-group label="Role" name="role_id" itemText="name"
                                                        itemValue="id" :items="$roles" data-choices-search-false
                                                        value="1" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.txt-group label="Enter Username" type="text"
                                                        name="username" placeholder="Enter your username" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.txt-group label="Enter new password" type="password"
                                                        name="password" placeholder="Enter your new password" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.txt-group label="Confirm password" type="password"
                                                        name="password_confirmation" placeholder="Confirm password" />
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <a href="javascript:void(0);"
                                                        class="link-primary text-decoration-underline">
                                                        Forgot Password ?
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">


                                        <button type="button" id="subBtn" onclick="store()" class="btn btn-primary">
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-soft-success">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>

                    {{-- endrow --}}
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('/assets/js/pages/profile-setting.init.js') }}"></script>

        <script>
            function store() {

                sLoading('subBtn');

                var form = document.getElementById('employee-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                var profileImgInput = document.getElementById('profile-img-file-input');
                var coverImgInput = document.getElementById('profile-foreground-img-file-input');

                if (profileImgInput.files.length > 0) {
                    payload.append('img', profileImgInput.files[0]);
                }

                if (coverImgInput.files.length > 0) {
                    payload.append('cover_img', coverImgInput.files[0]);
                }

                console.log(payload);

                const options = {
                    // contentType: 'application/json',
                    contentType: 'multipart/form-data',
                    method: 'POST',
                    headers: {
                        dataType: "json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        if (response.status) {
                            alertNotify(response.message, 'success')
                            $("#employee-form :input").val("");
                            associateErrors([], 'employee-form');
                            eLoading('subBtn')
                        } else {
                            associateErrors(response.errors, 'employee-form');
                            eLoading('subBtn')
                        }
                        // eLoading('subBtn')
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );

                console.log('fuck');


            }
        </script>
    @endpush
@endsection

<style>
    /* HTML: <div class="loader"></div> */
    .loader {
        --d: 22px;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        color: #25b09b;
        box-shadow:
            calc(1*var(--d)) calc(0*var(--d)) 0 0,
            calc(0.707*var(--d)) calc(0.707*var(--d)) 0 1px,
            calc(0*var(--d)) calc(1*var(--d)) 0 2px,
            calc(-0.707*var(--d)) calc(0.707*var(--d)) 0 3px,
            calc(-1*var(--d)) calc(0*var(--d)) 0 4px,
            calc(-0.707*var(--d)) calc(-0.707*var(--d))0 5px,
            calc(0*var(--d)) calc(-1*var(--d)) 0 6px;
        animation: l27 1s infinite steps(8);
    }

    @keyframes l27 {
        100% {
            transform: rotate(1turn)
        }
    }
</style>
