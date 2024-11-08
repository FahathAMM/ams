@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            {{-- <x-breadcrumb title="Assets" parent="Page" /> --}}

            <form id="branch-form" method="POST" action="{{ route('branch.store') }}" autocomplete="off"
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
                                            <x-input.txt-group label="Branch Name" name="branch_name"
                                                placeholder="Enter the branch name" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Branch Code" name="branch_code"
                                                placeholder="Enter the branch code" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Location Address" name="location_address"
                                                placeholder="Enter the branch address" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="City" name="city" placeholder="Enter the city" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="State" name="state"
                                                placeholder="Enter the state" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Country" name="country"
                                                placeholder="Enter the country" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="Postal Code" name="postal_code"
                                                placeholder="Enter the postal code" />
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
                                            <x-input.txt-group label="Email" name="email"
                                                placeholder="Enter the branch email" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            {{-- <x-input.txt-group label="Opening Date" name="opening_date"
                                                placeholder="Enter the branch opening date" type="date" /> --}}

                                            <x-input.date-group label="Joining Date" name="opening_date"
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
                                        <x-input.txtarea-group label="Description" name="notes"
                                            placeholder="Enter your description" />
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
                var form = document.getElementById('branch-form');
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
                            $("#branch-form :input").not("#is_active").val("");
                            // redirectTo('{{ route('user.index') }}');
                            alertNotify(response.message, 'success')
                            eLoading('sbtBtn')
                        } else {
                            associateErrors(response.errors, 'branch-form');
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
