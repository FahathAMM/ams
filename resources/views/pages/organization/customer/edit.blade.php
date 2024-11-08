@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            <form id="customer-form" method="POST" action="{{ route('customer.update', $customer->id) }}" autocomplete="off"
                enctype="multipart/form-data">
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
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Customer Code" name="customer_code"
                                            placeholder="Enter the customer code" value="{{ $customer->customer_code }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="First Name" name="first_name"
                                            placeholder="Enter the first name" value="{{ $customer->first_name }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Last Name" name="last_name"
                                            placeholder="Enter the last name" value="{{ $customer->last_name }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Company Name" name="company_name"
                                            placeholder="Enter the company name" value="{{ $customer->company_name }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Email" name="email"
                                            placeholder="Enter the customer email" value="{{ $customer->email }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Phone Number" name="phone_number"
                                            placeholder="Enter the contact number" value="{{ $customer->phone_number }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Address" name="address"
                                            placeholder="Enter the customer address" value="{{ $customer->address }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="City" name="city"
                                            placeholder="Enter the customer city" value="{{ $customer->city }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="State" name="state"
                                            placeholder="Enter the customer state" value="{{ $customer->state }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Postal Code" name="postal_code"
                                            placeholder="Enter the customer postal code"
                                            value="{{ $customer->postal_code }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.select-group label="Country" name="country" itemText="name"
                                            itemValue="value" :items="$countries" data-choices-search-true
                                            value="{{ $customer->country }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Website" name="website"
                                            placeholder="Enter the customer website" value="{{ $customer->website }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Business Type" name="business_type"
                                            placeholder="Enter the business type" value="{{ $customer->business_type }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Industry" name="industry" placeholder="Enter the industry"
                                            value="{{ $customer->industry }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Contact Person Name" name="contact_person_name"
                                            placeholder="Enter the contact person's name"
                                            value="{{ $customer->contact_person_name }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Contact Email" name="contact_email"
                                            placeholder="Enter the contact email" value="{{ $customer->contact_email }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.txt-group label="Contact Phone" name="contact_phone"
                                            placeholder="Enter the contact phone" value="{{ $customer->contact_phone }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.date-group label="Customer Since" name="customer_since"
                                            placeholder="Select date" value="{{ $customer->customer_since }}" />
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <x-input.select-group label="Status" name="is_active" itemText="name"
                                            itemValue="value" :items="[
                                                ['name' => 'Active', 'value' => '1'],
                                                ['name' => 'Inactive', 'value' => '2'],
                                            ]" data-choices-search-false
                                            value="{{ $customer->is_active }}" />
                                    </div>
                                    <div class="col-12 mb-3">
                                        <x-input.txtarea-group label="Description" name="description"
                                            placeholder="Enter customer description"
                                            value="{{ $customer->description }}"></x-input.txtarea-group>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end mb-3">
                                    <button type="button" onclick="updateCustomer()"
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
            function updateCustomer() {
                sLoading('sbtBtn');
                var form = document.getElementById('customer-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                const options = {
                    'contentType': 'multipart/form-data',
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
                            // redirectTo('{{ route('customer.index') }}');
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
