@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">
            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="{{ url('/assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="" />
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
                                {{-- <p class="text-muted mb-0">Lead Designer / Developer</p> --}}
                            </div>
                        </div>
                    </div>
                    <!--end card-->
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
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">30%</div>
                                </div>
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
                                <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com"
                                    value="www.velzon.com" />
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
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                        role="tab">
                                        <i class="fas fa-user"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="fas fa-lock"></i> Security
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form action="{{ route('user.store') }}" id="user-form" method="POST" class="tablelist-form"
                            autocomplete="off">
                            @csrf
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="First Name" name="first_name"
                                                        placeholder="Enter your first name" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Last Name" name="last_name"
                                                        placeholder="Enter your last name" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="User ID" name="id"
                                                        placeholder="Enter User ID" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Designation" name="designation"
                                                        placeholder="Enter your designation" />

                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Phone Number" name="contact"
                                                        placeholder="Enter your phone number" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group type="email" label="Email Address"
                                                        name="email" placeholder="Enter your email" />
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.date-group label="Joining Date" name="joining_date"
                                                        placeholder="Select date" />
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

                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <x-input.txtarea-group label="Description" name="description"
                                                        placeholder="Enter your description" />
                                                </div>
                                            </div>

                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <div class="row g-2">
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.select-group label="Role" name="role_id" itemText="name"
                                                        itemValue="id" :items="$roles" data-choices-search-false />
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
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.txt-group label="Confirm password" type="password"
                                                        name="password_confirmation" placeholder="Confirm password" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <a href="javascript:void(0);"
                                                        class="link-primary text-decoration-underline">
                                                        Forgot Password ?
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                        {{-- <div class="mt-4 mb-3 border-bottom pb-2">
                                            <div class="float-end">
                                                <a href="javascript:void(0);" class="link-primary">All Logout</a>
                                            </div>
                                            <h5 class="card-title">Login History</h5>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0 avatar-sm">
                                                <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                    <i class="ri-smartphone-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6>iPhone 12 Pro</h6>
                                                <p class="text-muted mb-0">
                                                    Los Angeles, United States - March 16 at 2:47PM
                                                </p>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);">Logout</a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0 avatar-sm">
                                                <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                    <i class="ri-tablet-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6>Apple iPad Pro</h6>
                                                <p class="text-muted mb-0">
                                                    Washington, United States - November 06 at 10:43AM
                                                </p>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);">Logout</a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0 avatar-sm">
                                                <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                    <i class="ri-smartphone-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6>Galaxy S21 Ultra 5G</h6>
                                                <p class="text-muted mb-0">
                                                    Conneticut, United States - June 12 at 3:24PM
                                                </p>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);">Logout</a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-sm">
                                                <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                    <i class="ri-macbook-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6>Dell Inspiron 14</h6>
                                                <p class="text-muted mb-0">
                                                    Phoenix, United States - July 26 at 8:10AM
                                                </p>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);">Logout</a>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <!--end tab-pane-->
                                </div>

                                <!--end col-->


                            </div>
                            <div class="card-footer">
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" onclick="store()" id="sbtBtn" class="btn btn-primary">
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-soft-success">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </form>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!-- container-fluid -->
    </div>

    @push('scripts')
        <script src="{{ asset('/assets/js/pages/profile-setting.init.js') }}"></script>

        <script>
            function store() {
                sLoading('sbtBtn')
                var form = document.getElementById('user-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                payload.append('img', document.getElementById('profile-img-file-input').files[0]);
                payload.append('cover_img', document.getElementById('profile-foreground-img-file-input').files[0]);


                const options = {
                    // contentType: 'application/json',
                    'contentType': 'multipart/form-data',
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
                        console.log('Success:', response.status);
                        if (response.status) {
                            $("#user-form :input").not("#is_active").val("");
                            // redirectTo('{{ route('user.index') }}');
                            alertNotify(response.message, 'success')
                            eLoading('sbtBtn')
                        } else {
                            associateErrors(response.errors, 'user-form');
                            eLoading('sbtBtn')
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            function redirectTo(url) {
                window.location.href = url;
            }

            function associateErrors(errors, formId) {
                console.log(formId);
                let $form = $(`#${formId}`);
                console.log($form);
                $form.find('.form-group .invalid-msg').text('');
                $form.find('.form-group .form-control').removeClass('is-invalid');

                Object.keys(errors).forEach(function(fieldName) {
                    let $group = $form.find('[name="' + fieldName + '"]');
                    // console.log('$group', $group);
                    console.log('fieldName', fieldName);
                    $group.addClass('is-invalid');
                    $group.closest('.form-group').find('.invalid-msg').text(errors[fieldName][0]);
                });
            }
        </script>
    @endpush
@endsection
