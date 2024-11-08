@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            {{-- <x-breadcrumb title="Edit Department" parent="Departments" /> --}}

            <form id="department-form" method="POST" action="{{ route('department.update', $department->id) }}"
                autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                                placeholder="Enter the department name"
                                                value="{{ $department->department_name }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Department Code" name="department_code"
                                                placeholder="Enter the department code"
                                                value="{{ $department->department_code }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.select-group label="Branch" name="branch_id" itemText="branch_name"
                                                itemValue="id" :items="$branch" value="{{ $department->branch_id }}"
                                                data-choices-search-true />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Email" name="email"
                                                placeholder="Enter the department email" value="{{ $department->email }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Phone Number" name="phone_number"
                                                placeholder="Enter the contact number"
                                                value="{{ $department->phone_number }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.date-group label="Established Date" name="established_date"
                                                placeholder="Select date" value="{{ $department->established_date }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.select-group label="Status" name="is_active" itemText="name"
                                                itemValue="value" :items="[
                                                    ['name' => 'Active', 'value' => 1],
                                                    ['name' => 'Inactive', 'value' => 0],
                                                ]" value="{{ $department->is_active }}"
                                                data-choices-search-false />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <x-input.txtarea-group label="Description" name="description"
                                            placeholder="Enter department description">{{ $department->description }}</x-input.txtarea-group>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end mb-3">
                                    <button type="button" onclick="store()"
                                        class="btn btn-success w-sm sbtBtn">Update</button>
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
                sLoading('sbtBtn');
                var form = document.getElementById('department-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                const options = {
                    contentType: 'multipart/form-data',
                    method: method,
                    headers: {
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
                            alertNotify(response.message, 'success');
                            eLoading('sbtBtn');
                            // Redirect after success
                            redirectTo('{{ route('department.index') }}');
                        } else {
                            associateErrors(response.errors, 'department-form');
                            eLoading('sbtBtn');
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
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
