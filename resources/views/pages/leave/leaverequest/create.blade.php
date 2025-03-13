@extends('layout.app')
@section('title', $title)
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <div class="error-container" style="display:none;">
                <div class="alert alert-danger">
                    <h4>There were some problems with your input:</h4>
                    <ul class="error-list"></ul>
                </div>
            </div>

            <form id="leave-request-form" method="POST" action="{{ route('leave.store') }}" autocomplete="off"
                class="needs-validation1" novalidate1 enctype="multipart/form-data">
                <input type="hidden" name="start_date" value="{{ $data['start'] }}">
                <input type="hidden" name="end_date" value="{{ isset($data['end']) ? $data['end'] : $data['start'] }}">
                <input type="hidden" name="applied_employee_id" value="{{ $currentEmployeeId }}">
                <input type="hidden" name="request_days" value="{{ $selectLeaveDays }}">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <div>
                                                <div class="mb-3 position-relative leave-report-employee">
                                                    <x-input.select-group label="Report To" id="employee_id"
                                                        name="employee_id[]" itemText="full_name" itemValue="id"
                                                        :items="$leaveReportEmployees" multiple data-choices data-choices-removeItem
                                                        :value="1" placeholder="" class="email-compose-input" />

                                                    {{-- <div class="position-absolute top-0 end-0">
                                                        <div class="d-flex">
                                                            <button class="btn btn-link text-reset fw-semibold px-2"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#CcRecipientsCollapse" aria-expanded="false"
                                                                aria-controls="CcRecipientsCollapse"
                                                                style="margin-top: 27px;">
                                                                Cc
                                                            </button>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                {{-- <div class="collapse" id="CcRecipientsCollapse">
                                                    <div class="mb-3">
                                                        <label>Cc:</label>
                                                        <select class="form-control" id="choices-multiple-remove-button"
                                                            data-choices data-choices-removeItem
                                                            name="choices-multiple-remove-button" multiple>
                                                            <option value="Choice 1" selected>Choice 1</option>
                                                            <option value="Choice 2">Choice 2</option>
                                                            <option value="Choice 3">Choice 3</option>
                                                            <option value="Choice 4">Choice 4</option>
                                                        </select>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-input.select-group label="Leave Type" name="leave_type_id" itemText="name"
                                                itemValue="id" :items="$leaveTypes" class="email-compose-input" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Overview</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $userDetails = [
                                        'Start Date' => $data['start'],
                                        'End Date' => isset($data['end']) ? $data['end'] : $data['start'],
                                        'Total Request Day(s)' => $selectLeaveDays ?? '',
                                        'Employee ID' => currentUser()->employee->emp_number ?? '',
                                        'Employee Name' => currentUser()->full_name ?? '',
                                        'Designation' => currentUser()->employee->designation ?? '',
                                    ];
                                @endphp
                                <div class="vstack gap-1">
                                    @foreach ($userDetails as $key => $value)
                                        <div class="d-flex align-items-center border-bottom">
                                            <div class="flex-grow-1 w-50">
                                                <h5 class="fs-13 mb-0">
                                                    <label class="text-body d-block mb-1">
                                                        {{ ucfirst($key) }} <!-- Capitalize the first letter of the key -->
                                                    </label>
                                                </h5>
                                            </div>
                                            <div class="flex-shrink-0 text-start">
                                                <div class="d-flex align-items-center gap-1">
                                                    <label class="mb-1 fw-normal">{{ $value }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Reason</h5>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    <x-input.ckeditor id="new-content" name="body" />
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="button" onclick="store()" class="btn btn-success w-sm">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <script>
            $('document').ready(function() {
                var ckClassicEditor = document.querySelectorAll("#new-content")
                ckClassicEditor.forEach(function() {
                    ClassicEditor
                        .create(document.querySelector('#new-content'))
                        .then(function(editor) {
                            editor.ui.view.editable.element.style.height = '200px';
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                });
            });

            let formName = 'leave-request-form';

            function store() {
                let reportingMangerId = getValue('employee_id');
                console.log('reportingMangerId', reportingMangerId);

                if (!reportingMangerId) {
                    console.log(1);
                    alertNotify(
                        'We could not find your reporting manager. If one has not been assigned, please assign one and try again.',
                        'error')
                    return;
                }

                $('#new-content').html($('.ck-content').html());
                var form = document.getElementById(formName);
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);

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
                            // $("#task-form :input").val("");
                            $('.error-container').hide();
                            associateErrors([], formName);
                        } else {
                            alertNotify('Please ensure input is not empty', 'error')
                            associateErrors(response.errors, formName);


                            showErrorMsg(response)

                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            function showErrorMsg(response) {
                // Clear previous errors
                $('.error-list').empty();

                // Loop through the errors and display them
                $.each(response.errors, function(key, messages) {
                    // Remove the trailing .0 from the key
                    let formattedKey = key.replace(/\.0$/, '');
                    formattedKey = formattedKey.replace('.', ' '); // Optional: Replace '.' with space

                    let errorHtml = `<li><strong>${formattedKey}:</strong><ul>`;
                    messages.forEach(function(message) {
                        errorHtml += `<li>${message}</li>`;
                    });
                    errorHtml += '</ul></li>';

                    $('.error-list').append(errorHtml);
                });

                // Show the error container (if hidden)
                $('.error-container').show();
            }
        </script>
    @endpush

    @push('styles')
        <style>
            .error-container {
                margin-top: 20px;
            }

            .alert-danger {
                border: 1px solid #dc3545;
                background-color: #f8d7da;
                color: #721c24;
                padding: 15px;
            }

            .error-list li {
                margin: 5px 0;
            }

            .leave-report-employee .choices__item {
                margin-top: 6px !important
            }
        </style>
    @endpush
@endsection
