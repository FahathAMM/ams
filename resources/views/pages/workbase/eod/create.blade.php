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

            <form id="task-form" method="POST" action="{{ route('eodreport.store') }}" autocomplete="off"
                class="needs-validation1" novalidate1 enctype="multipart/form-data">
                <input type="hidden" name="repoting_manager_id" id="repoting_manager_id"
                    value="{{ $repotingManagers->reportManager[0]->id ?? '' }}">
                <input type="hidden" name="date" value="{{ $date }}">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <x-input.txt-group label="EOD Subject" name="subject"
                                                placeholder="Enter your EOD Subject" />
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
                                        'EOD Date' => $date,
                                        'Employee ID' => currentUser()->employee->emp_number ?? '',
                                        'Employee Name' => currentUser()->full_name ?? '',
                                        'Designation' => currentUser()->employee->designation ?? '',
                                        'repotingManagers' => $repotingManagers->reportManager[0]->full_name ?? '',
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
                                <p class="text-muted mb-2">
                                    <button type="button" id="newRow"
                                        class="float-end add-row btn fw-medium btn-soft-secondary">
                                        <i class="ri-add-fill me-1 align-bottom"></i>
                                        Add New
                                    </button>
                                <h5 class="card-title mb-0">Add EOD</h5>
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    <div class="table-responsivew">
                                        <table class="invoice-table table table-borderless table-nowrap mb-0">
                                            <tbody id="newlink">
                                                <tr id="1" class="product">
                                                    <td class="text-start py-0" style="width:200px">
                                                        <div class="mb-0">
                                                            <x-input.txt-group name="task_id[]"
                                                                placeholder="Enter your  Task ID" />
                                                        </div>
                                                    </td>
                                                    <td class="text-start py-0 w-25">
                                                        <div class="mb-0">
                                                            <x-input.select-group name="customer_id[]"
                                                                itemText="company_name" itemValue="id" :items="$customers"
                                                                placeholder="Select customer" />
                                                        </div>
                                                    </td>
                                                    <td class="py-0" style="width:45%">
                                                        <div>
                                                            <x-input.txt-group name="task_description[]"
                                                                placeholder="Enter your  Task description" />
                                                        </div>
                                                    </td>
                                                    <td class="py-0" style="width:150px">
                                                        <div>
                                                            <x-input.select-group name="task_status[]" itemText="name"
                                                                itemValue="value" :items="[
                                                                    ['name' => 'Completed', 'value' => 'completed'],
                                                                    ['name' => 'WIP', 'value' => 'wip'],
                                                                    ['name' => 'Pending', 'value' => 'pending'],
                                                                ]"
                                                                data-choices-search-false />
                                                        </div>
                                                    </td>
                                                    <td class="py-0" style="width:150px">
                                                        <div>
                                                            <x-input.time-group name="task_duration[]"
                                                                data-provider="timepickr" data-time-hrs="true"
                                                                id="timepicker-24hrs" />
                                                        </div>
                                                    </td>
                                                    <td class="product-removal py-0">
                                                        <a href="javascript:void(0)" class="btn btn-danger remove-row">
                                                            <i class="ri-delete-bin-5-line"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Description</h5>
                            </div>
                            <div class="card-body">
                                <div class="mt-3">
                                    <x-input.ckeditor id="new-content" name="description" />
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

                let i = 1;

                $(document).on('click', '.add-row', function() {
                    let name = `customer${i}`;
                    var newRow = `
                    <tr class="product">
                        <td class="text-start py-0" style="width:200px">
                            <div class="mb-0">
                                <x-input.txt-group name="task_id[]" placeholder="Enter your  Task ID"/>
                            </div>
                        </td>
                         <td class="text-start py-0 w-25">
                            <div class="mb-0">
                                <x-input.select-group name="customer_id[]" id="${name}" itemText="company_name" placeholder="Select customer"
                                    itemValue="id" :items="$customers" />
                            </div>
                        </td>
                        <td class="py-0" style="width:45%">
                            <div>
                                <x-input.txt-group name="task_description[]"
                                    placeholder="Enter your  Task description" />
                            </div>
                        </td>
                         <td class="py-0" style="width:150px">
                            <div> <x-input.select-group name="task_status[]" itemText="name" itemValue="value" :items="[ ['name' => 'Completed', 'value' => 'completed'], ['name' => 'WIP', 'value' => 'wip'], ['name' => 'Pending', 'value' => 'pending'] ]" data-choices-search-false /> </div>
                         </td>
                           <td class="py-0" style="width:150px">
                            <div>
                                <x-input.time-group name="task_duration[]" data-provider="timepickr" data-time-hrs="true" id="timepicker-24hrs" />
                            </div>
                        </td>
                        <td class="product-removal py-0">
                            <a href="javascript:void(0)" class="btn btn-danger remove-row">
                                <i class="ri-delete-bin-5-line"></i>
                            </a>
                        </td>
                    </tr>`;

                    $('#newlink').append(newRow);

                    setTimeout(() => {
                        const element = document.querySelector(`#${name}`);
                        console.log('element', element);

                        const choices = new Choices(element);
                    }, 100);
                    i++;
                });

                $(document).on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                });

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


            function store() {

                let reportingMangerId = getValue('repoting_manager_id');

                if (!reportingMangerId) {
                    console.log(1);
                    alertNotify(
                        'We could not find your reporting manager. If one has not been assigned, please assign one and try again.',
                        'error')
                    return;
                }

                $('#new-content').html($('.ck-content').html());
                var form = document.getElementById('task-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);


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
                            associateErrors(response.errors, 'task-form');
                        } else {
                            alertNotify('Please ensure input is not empty', 'error')
                            associateErrors(response.errors, 'task-form');


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
        </style>
    @endpush
@endsection
