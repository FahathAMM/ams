@extends('layout.app')
@section('title', $titleName)
@section('content')
    @push('styles')
    @endpush

    {{-- @dd($employee) --}}

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

            <form action="{{ route('employee.update', ['employee' => $employee->id]) }}" id="employee-form" method="POST"
                class="tablelist-form" autocomplete="off">
                @method('PUT')
                @csrf

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                        <img src="{{ $employee->img }}"
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
                                <h5 class="card-title mb-0">Repoting Managers</h5>
                            </div>
                            <!-- end card body -->
                            <div class="card-body">
                                {{-- <pre>
                                    {{ $employee->reportManager[0]['id'] }}
                                </pre> --}}
                                <div>
                                    <x-input.select-group label="EOD Reporting Manager" name="report_manager_id"
                                        itemText="full_name" itemValue="id" :items="$employees" :value="$employee->reportManager[0]['id'] ?? ''"
                                        data-choices-search-true />
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
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#leaveManagment" role="tab">
                                            <i class="far fa-user"></i> Leave
                                        </a>
                                    </li>
                                </ul>
                            </div>

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
                                                        placeholder="Enter your first name" :value="$employee->first_name" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Last Name" name="last_name"
                                                        placeholder="Enter your last name" :value="$employee->last_name" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Employee ID" name="emp_number"
                                                        placeholder="Enter employee ID" type="text" :value="$employee->emp_number"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Designation" name="designation"
                                                        placeholder="Enter your designation" :value="$employee->designation" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group label="Phone Number" name="phone_number"
                                                        placeholder="Enter your phone number" :value="$employee->phone_number" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group type="email" label="Email Address"
                                                        name="email" placeholder="Enter your email" :value="$employee->email"
                                                        required />
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Branch" name="branch_id"
                                                        itemText="branch_name" itemValue="id" :items="$branches"
                                                        data-choices-search-false :value="$employee->branch_id" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Department" name="department_id"
                                                        itemText="department_name" itemValue="id" :items="$departments"
                                                        data-choices-search-false :value="$employee->department_id" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.date-group label="Joining Date" name="joining_date"
                                                        placeholder="Select date" :value="$employee->joining_date" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Country" name="country" itemText="name"
                                                        itemValue="value" :items="$countries" data-choices-search-true
                                                        :value="$employee->country" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Gender" name="gender" itemText="name"
                                                        itemValue="value" :items="[
                                                            ['name' => 'Male', 'value' => '1'],
                                                            ['name' => 'Female', 'value' => '2'],
                                                        ]" data-choices-search-false
                                                        :value="$employee->gender" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.select-group label="Status" name="is_active" itemText="name"
                                                        itemValue="value" :items="[
                                                            ['name' => 'Active', 'value' => '1'],
                                                            ['name' => 'Deactive', 'value' => '0'],
                                                        ]" data-choices-search-false
                                                        :value="$employee->is_active" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <x-input.txtarea-group label="Description" name="description"
                                                        placeholder="Enter your description" :value="$employee->description" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <div class="row g-2">
                                            {{-- <div class="col-lg-6">
                                                <div>
                                                    <x-input.select-group label="Role" name="role_id" itemText="name"
                                                        itemValue="id" :items="$roles" data-choices-search-false
                                                        :value="$employee->role_id" />
                                                </div>
                                            </div> --}}
                                            <div class="col-lg-12">
                                                <div>
                                                    <x-input.txt-group label="Enter Username" type="text"
                                                        name="username" placeholder="Enter your username"
                                                        :value="$employee->username" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <x-input.txt-group label="Enter new password" type="password"
                                                        name="password" placeholder="Enter your new password" required />
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
                                    <div class="tab-pane" id="leaveManagment" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div style=" border: 1px solid #e2e3ea; padding: 20px 10px; border-radius: 5px; "
                                                    class="mt-3">
                                                    <legend class="fs-14 legend-leave">
                                                        Leave Category
                                                    </legend>
                                                    <div class="row">
                                                        @foreach ($leaveTypes as $type)
                                                            <div class="col-md-3 col-lg-3 col-sm-6">
                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="type-{{ $type->id }}" name="leave_types[]"
                                                                        value="{{ $type->id }}"
                                                                        @checked(in_array($type->id, $employee->leave_types ?? []))>
                                                                    <label class="form-check-label"
                                                                        for="type-{{ $type->id }}">
                                                                        {{ $type->name }} ({{ $type->number_of_days }})
                                                                    </label>
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
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('/assets/js/pages/profile-setting.init.js') }}"></script>

        <script>
            function store() {

                // sLoading('subBtn');

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


            }
        </script>
    @endpush
@endsection
