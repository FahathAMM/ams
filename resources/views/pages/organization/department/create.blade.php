@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            {{-- <x-breadcrumb title="Departments" parent="Page" /> --}}

            <form id="department-form" method="POST" action="{{ route('department.store') }}" autocomplete="off"
                class="needs-validation1" novalidate1 enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ $title }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Department Name" name="department_name"
                                                placeholder="Enter the department name" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Department Code" name="department_code"
                                                placeholder="Enter the department code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            {{-- <x-input.txt-group label="Branch ID" name="branch_id"
                                                placeholder="Enter the branch ID" /> --}}
                                            <x-input.select-group label="Branch" name="branch_id" itemText="branch_name"
                                                itemValue="id" :items="$branch" data-choices-search-true />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Email" name="email"
                                                placeholder="Enter the department email" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Phone Number" name="phone_number"
                                                placeholder="Enter the contact number" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.date-group label="Established Date" name="established_date"
                                                placeholder="Select date" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.select-group label="Status" name="is_active" itemText="name"
                                                itemValue="value" :items="[
                                                    ['name' => 'Active', 'value' => 1],
                                                    ['name' => 'Inactive', 'value' => 0],
                                                ]" data-choices-search-false />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <x-input.txtarea-group label="Description" name="description"
                                            placeholder="Enter department description" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end mb-3">
                                    <button type="button" onclick="store()"
                                        class="btn btn-success w-sm sbtBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function store() {
                sLoading('sbtBtn')
                var form = document.getElementById('department-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

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
                            $("#department-form :input").not("#is_active").val("");
                            // redirectTo('{{ route('department.index') }}');
                            alertNotify(response.message, 'success')
                            eLoading('sbtBtn')
                        } else {
                            associateErrors(response.errors, 'department-form');
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
                let $form = $(`#${formId}`);
                $form.find('.form-group .invalid-msg').text('');
                $form.find('.form-group .form-control').removeClass('is-invalid');

                Object.keys(errors).forEach(function(fieldName) {
                    let $group = $form.find('[name="' + fieldName + '"]');
                    $group.addClass('is-invalid');
                    $group.closest('.form-group').find('.invalid-msg').text(errors[fieldName][0]);
                });
            }
        </script>
    @endpush
@endsection
