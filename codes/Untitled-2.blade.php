@extends('layout.app')
@section('content')
    @push('styles')
        <style>
            table.dataTable tr {
                border: 2px solid #dbdade;
            }

            table.dataTable {
                border-top: 1px solid #dbdade;
                border-right: 1px solid #dbdade;
                border-left: 1px solid #dbdade;
            }
        </style>
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
                                    <img src="{{ url('/assets/images/users/avatar-1.jpg') }}"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                        alt="user-profile-image" />
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input" />
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="fs-16 mb-1">Anna Adame</h5>
                                <p class="text-muted mb-0">Lead Designer / Developer</p>
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
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('employee.store') }}" id="employee-form" method="POST"
                                        class="tablelist-form" autocomplete="off">
                                        @csrf
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
                                                    <x-input.txt-group label="Employee ID" name="employee_id"
                                                        placeholder="Enter employee ID" />
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
                                                    <x-input.txt-group label="Phone Number" name="phone_number"
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

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="skillsInput" class="form-label">Branch</label>
                                                    <select class="form-control mb-0" data-choices
                                                        data-choices-search-false name="branch" id="branch">
                                                        <option value="" selected>Choose..</option>
                                                        <option value="Dubai">Dubai</option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="India">India</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="skillsInput" class="form-label">Department</label>
                                                    <select class="form-control mb-0" data-choices
                                                        data-choices-search-false name="department" id="department">
                                                        <option value="" selected>Choose..</option>
                                                        <option value="Management">Management</option>
                                                        <option value="Development">Development</option>
                                                        <option value="Sales">Sales</option>
                                                        <option value="Finance">Finance</option>
                                                        <option value="Administration">Administration</option>
                                                        <option value="IT Infrastructure">IT Infrastructure</option>
                                                        <option value="Hardware">Hardware</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.date-group label="Joining Date" name="joining_date"
                                                        placeholder="Select date" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <x-input.txt-group type="text" label="Country" name="country"
                                                        placeholder="Enter your country" />
                                                </div>
                                            </div>

                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <x-input.txtarea-group label="Description" name="description"
                                                        placeholder="Enter your description" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" onclick="store(this)" class="btn btn-primary">
                                                        Submit
                                                    </button>
                                                    <button type="button" class="btn btn-soft-success">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="oldpasswordInput" class="form-label">Old
                                                        Password*</label>
                                                    <input type="password" class="form-control" id="oldpasswordInput"
                                                        placeholder="Enter current password" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newpasswordInput" class="form-label">New
                                                        Password*</label>
                                                    <input type="password" class="form-control" id="newpasswordInput"
                                                        placeholder="Enter new password" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmpasswordInput" class="form-label">Confirm
                                                        Password*</label>
                                                    <input type="password" class="form-control" id="confirmpasswordInput"
                                                        placeholder="Confirm password" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <a href="javascript:void(0);"
                                                        class="link-primary text-decoration-underline">Forgot
                                                        Password ?</a>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">
                                                        Change Password
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                    <div class="mt-4 mb-3 border-bottom pb-2">
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
                                    </div>
                                </div>
                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!-- container-fluid -->
    </div>

    @push('scripts')
        <script src="{{ url('/assets/js/pages/profile-setting.init.js') }}"></script>

        <script>
            $(function() {

            });

            $('document').ready(function() {});

            function submitFormWithFetch(formId) {
                var form = document.getElementById(formId);
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var formData = new FormData(form);

                var payload = {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                };

                if (method === 'POST' || method === 'PUT') {
                    payload.body = formData;
                }

                fetch(url, payload)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Handle successful validation
                        associateErrors(data.errors, formId);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }

            function associateErrors1(errors, $formId) {
                $form.find('.form-group').removeClass('has-errors').find('.help-text').text('');

                $.each(errors, function(fieldName, errorMessages) {
                    var $group = $form.find('[name="' + fieldName + '"]').closest('.form-group');
                    $group.addClass('has-errors').find('.help-text').text(errorMessages.join(', '));
                });
            }

            function associateErrors(errors, formId) {
                var $form = $(`#${formId}`);
                $form.find('.form-group .invalid-msg').text('');
                $form.find('.form-group .form-control').removeClass('is-invalid');

                Object.keys(errors).forEach(function(fieldName) {
                    var $group = $form.find('[name="' + fieldName + '"]');

                    $group.addClass('is-invalid');
                    $group.closest('.form-group').find('.invalid-msg').text(errors[fieldName][0]);
                });
            }

            function importbranch() {
                let payload = new FormData();
                payload.append("branchs", this.files);
                payload.append("company_id", this.$auth?.user?.company?.id);
                let options = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                this.btnLoader = true;
                this.$axios
                    .post("/branch/import", payload, options)
                    .then(({
                        data
                    }) => {
                        this.btnLoader = false;
                        if (!data.status) {
                            this.errors = data.errors;
                            payload.delete("branchs");
                        } else {
                            this.errors = [];
                            this.snackbar = true;
                            this.response = "branchs imported successfully";
                            this.getDataFromApi();
                            this.close();
                        }
                    })
                    .catch((e) => {
                        if (e.toString().includes("Error: Network Error")) {
                            this.errors = [
                                "File is modified.Please cancel the current file and try again",
                            ];
                            this.btnLoader = false;
                        }
                    });
            },

            function submitForm() {
                let formData = new FormData(document.getElementById('myForm'));

                makeFetchRequest(
                    '/submit-form',
                    'POST',
                    formData,
                    function(data) {
                        console.log(data);
                        // Handle the response as needed
                    },
                    function(error) {
                        console.error('Error:', error);
                        // Handle errors
                    }
                );
            }

            function makeFetchRequest(url, method, payload, successCallback, errorCallback) {
                let headers = {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                };

                let body;

                if (method.toUpperCase() === 'GET') {
                    // Handle GET requests
                    url += '?' + new URLSearchParams(payload).toString();
                } else {
                    // Handle other HTTP methods (POST, PUT, DELETE, etc.)
                    headers['Content-Type'] = 'application/json';
                    body = JSON.stringify(payload);
                }

                fetch(url, {
                        method: method,
                        headers: headers,
                        body: body,
                    })
                    .then(response => response.json())
                    .then(data => {
                        successCallback(data);
                    })
                    .catch(error => {
                        errorCallback(error);
                    });
            }


            function associate_errors11(errors, $form) {
                // remove existing error classes and error messages from form groups
                $form.find('.form-group').find('.invalid-msg').text('');
                $form.find('.form-group').find('.form-control').removeClass('is-invalid');

                // iterate over the keys of the error object
                Object.keys(errors).forEach(function(fieldName) {
                    // find each form group, which is given a unique id based on the form field's name
                    var $group = $form.find('[name="' + fieldName + '"]');

                    // add the error class and set the error text
                    $group.addClass('is-invalid');
                    $group.closest('.form-group').find('.invalid-msg').text(errors[fieldName][0]);
                });
            }

            function store(e) {
                // var $form = $('#employee-form');
                submitFormWithFetch('employee-form');
            }


            // ========form submit============
            $('#btn').submit(function(e) {
                var $form = $(this);
                e.preventDefault(); // keeps the form from behaving like a normal (non-ajax) HTML form
                var url = $form.attr('action');
                var formData = {};

                // submit a POST request with the form data
                $form.find('input, select').each(function() {
                    formData[$(this).attr('name')] = $(this).val();
                });

                // submits an array of key-value pairs to the form's action URL
                $.post(url, formData, function(response) {
                    // handle successful validation
                    $("#role-card-area").load(location.href + " #role-card-area");
                    $('#addRoleModal').modal('hide');

                }).fail(function(response) {
                    // handle failed validation
                    associate_errors11(response.responseJSON.errors, $form);
                });
            });
        </script>
    @endpush
@endsection
