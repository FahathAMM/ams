@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            <form id="customer-form" method="POST" action="{{ route('customer.store') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ $title }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Customer Code" name="customer_code"
                                            placeholder="Enter the customer code" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="First Name" name="first_name"
                                            placeholder="Enter the first name" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Last Name" name="last_name"
                                            placeholder="Enter the last name" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Company Name" name="company_name"
                                            placeholder="Enter the company name" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Email" name="email"
                                            placeholder="Enter the customer email" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Phone Number" name="phone_number"
                                            placeholder="Enter the contact number" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Address" name="address"
                                            placeholder="Enter the customer address" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="City" name="city"
                                            placeholder="Enter the customer city" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="State" name="state"
                                            placeholder="Enter the customer state" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Postal Code" name="postal_code"
                                            placeholder="Enter the customer postal code" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.select-group label="Country" name="country" itemText="name"
                                            itemValue="value" :items="$countries" data-choices-search-true />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Website" name="website"
                                            placeholder="Enter the customer website" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Business Type" name="business_type"
                                            placeholder="Enter the business type" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Industry" name="industry"
                                            placeholder="Enter the industry" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Contact Person Name" name="contact_person_name"
                                            placeholder="Enter the contact person's name" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Contact Email" name="contact_email"
                                            placeholder="Enter the contact email" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Contact Phone" name="contact_phone"
                                            placeholder="Enter the contact phone" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.date-group label="Customer Since" name="customer_since"
                                            placeholder="Select date" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.select-group label="Status" name="is_active" itemText="name"
                                            itemValue="value" :items="[
                                                ['name' => 'Active', 'value' => '1'],
                                                ['name' => 'Inactive', 'value' => '2'],
                                            ]" data-choices-search-false value="1" />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input.txtarea-group label="Description" name="description"
                                            placeholder="Enter customer description" />
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
                sLoading('sbtBtn');
                var form = document.getElementById('customer-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                const options = {
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
                            $("#customer-form :input").not("#is_active").val("");
                            alertNotify(response.message, 'success');
                            eLoading('sbtBtn');
                            associateErrors(response.errors, 'customer-form');
                        } else {
                            associateErrors(response.errors, 'customer-form');
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
