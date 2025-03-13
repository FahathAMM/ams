@extends('layout.app')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-8">
                    <div id="job-list" class="row">
                        @foreach ($LeaveRequestListByReportingManager as $item)
                            @php
                                // echo '<pre>' . json_encode($item, JSON_PRETTY_PRINT) . '</pre>';
                            @endphp
                            <div class=" col-md-4 col-lg-4 col-xl-4 px-0 mx-0 mb-1">
                                <div class="card mx-1 h-100 joblist-card ribbon-box border shadow-none mb-lg-0 right">
                                    <div class="card-body pb-0">
                                        <div class="ribbon-two ribbon-two-info fs-11">
                                            <span class="fs-10">{{ $item->status ?? '' }} </span>
                                        </div>
                                        <div
                                            class="d-flex mb-2 border border-dased border-start-0 border-end-0 border-top-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ $item->appliedEmployee->img ?? '' }}" alt=""
                                                        class="avatar-sm rounded-circle companyLogo-img">
                                                </div>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <img src="{{ $item->appliedEmployee->img ?? '' }}" alt=""
                                                    class="d-none cover-img">
                                                <a href="#!">
                                                    <h6 class="job-title mb-0">
                                                        {{ $item->appliedEmployee->full_name ?? '' }}
                                                    </h6>
                                                </a>
                                                <p class="company-name fs-12 text-muted mb-0">
                                                    Created on {{ date('d M Y', strtotime($item->created_at)) ?? '' }}
                                                </p>
                                                <a class="company-name fs-10 mb-0 badge bg-success" style="cursor:pointer"
                                                    onclick="reviewLeaveRequest('{{ $item->status }}', {{ Js::from($item) }})">
                                                    Review
                                                </a>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <p class="text-muted job-description fs-10 mb-0">
                                            {!! $truncated = Str::limit($item->body, 150, ' ...') !!}
                                        </p>
                                    </div>

                                    <div class="card-footer border-top-dashed pb-0">
                                        <div class="d-flex align-items-center py-0">
                                            <div class="flex-grow-1">
                                                <div>
                                                    <i class="ri-briefcase-2-line align-bottom me-1"></i>
                                                    <span class="fs-11 text-muted mb-0">Leave Type</span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <span class="job-postdate fs-11">{{ $item->leaveType->name ?? '' }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center py-0">
                                            <div class="flex-grow-1">
                                                <div>
                                                    <i class="ri-briefcase-2-line align-bottom me-1"></i>
                                                    <span class="fs-11 text-muted mb-0">Request Days</span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <span class="job-postdate fs-11">{{ $item->request_days ?? '' }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center pb-1">
                                            <div class="flex-grow-1">
                                                <div>
                                                    <i class="ri-briefcase-2-line align-bottom me-1"></i>
                                                    <span class="fs-11 text-muted mb-0">Remaining Days</span>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <span class="job-postdate fs-11">{{ $item->remaining_days }}</span>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row g-0 justify-content-end mb-2" id="pagination-element"
                        style="position: absolutes; bottom: 0; width: 100%; ">
                        <div class="col-sm-12">
                            {{ $LeaveRequestListByReportingManager->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4">
                    <div class="card job-list-view-card overflow-hiddena" id="job-overview">
                        <img src="https://protoverify.com/wp-content/uploads/2023/08/Employee-Background-Verification-in-India-A-Guide-for-Employers.jpg"
                            alt="" id="cover-img" {{-- <img src="{{ asset('assets/images/small/img-10.jpg') }}" alt="" id="cover-img" --}}
                            class="img-fluid background object-fit-cover">
                        <div class="card-body">

                            <div class="avatar-md mt-n5 img-thumbnail rounded-circle flex-shrink-0">
                                <img id="view-userimg" src="http://localhost/ams/public/storage/demo/dm-profile.jpg"
                                    alt="" class="member-img img-fluid d-block rounded-circle"
                                    style="width:73px;height:63px;">
                            </div>

                            <div class="mt-3">
                                <h5 class="view-title" id="view-username">Employee Name</h5>
                                <div class="hstack gap-3 mb-3">
                                    <span class="text-muted"><i class="ri-calendar-2-line me-1 align-bottom"></i>
                                        <span id="view-department"></span>
                                    </span>
                                    <span class="text-muted"><i class="ri-chat-history-line me-1 align-bottom"></i>
                                        <span id="view-status" class="badge bg-success"></span>
                                    </span>
                                </div>
                                <p class="text-muted" id="view-body">.</p>
                                <div class="py-3 border border-dashed border-start-0 border-end-0 mt-4">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-12 text-muted">Leave Type</p>
                                                <h5 class="fs-12 mb-0" id="view-leave-type"></h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-12 text-muted"> Request Days
                                                </p>
                                                <h5 class="fs-12 mb-0" id="view-request-days"></h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div>
                                                <p class="mb-2 text-uppercase fw-medium fs-12 text-muted">Remaining Days</p>
                                                <h5 class="fs-12 mb-0" id="view-remaining-days"></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="my-3">
                                {{-- <x-input.select-group name="status" label="Status" itemText="name" itemValue="value"
                                    :items="[
                                        ['name' => 'Pending', 'value' => 'Pending'],
                                        ['name' => 'Approved', 'value' => 'Approved'],
                                        ['name' => 'Rejected', 'value' => 'Rejected'],
                                    ]" data-choices-search-false :value="1" required /> --}}

                                <x-input.select-group-js name="status" label="Status" itemText="name" itemValue="value"
                                    :items="[
                                        ['name' => 'Pending', 'value' => 'Pending'],
                                        ['name' => 'Approved', 'value' => 'Approved'],
                                        ['name' => 'Rejected', 'value' => 'Rejected'],
                                    ]" data-choices-search-false :value="1" required />
                                <x-input.hidden id="leave_request_id" />
                                <x-input.hidden id="reporting_manager_id" />
                                <x-input.hidden id="leave_type_id" />
                                <x-input.hidden id="number_of_days" />
                                <x-input.hidden id="applied_employee_id" />
                            </div>
                            <div class="mb-3">
                                <x-input.txtarea-group label="Reason (Optional)" name="reason"
                                    placeholder="Enter your description" />
                            </div>
                            <div class="mt-4">
                                <button type="button" class="btn btn-success w-100" onclick="submit()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function reviewLeaveRequest(id, item) {
                console.log(item);



                let start_date = new Date(item.start_date).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                let end_date = new Date(item.end_date).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                let reason = item?.status == 'Approved' ? item.approved_reason : item.rejected_reason

                setImage('view-userimg', item?.applied_employee?.img);
                setHtml('view-username', item?.applied_employee?.full_name);
                setHtml('view-username', item?.applied_employee?.full_name);
                setHtml('view-status', item?.status);
                setHtml('view-department', `${ start_date} - ${ end_date}`);
                setHtml('view-body', item?.body);
                setHtml('view-leave-type', item?.leave_type?.name);
                setHtml('view-request-days', item?.request_days);
                setHtml('view-remaining-days', item?.remaining_days);
                setValue('leave_request_id', item?.id)
                setValue('reporting_manager_id', item?.reporting_manager)
                setValue('leave_type_id', item?.leave_type?.id)
                setValue('number_of_days', item?.request_days)
                setValue('applied_employee_id', item?.applied_employee?.id)
                updateSelectedValue('status', item?.status)
                setValue('reason', reason)
            }

            async function submit() {
                const leaveRequestId = getValue('leave_request_id');
                const status = getValue('status');

                // Validate required fields
                if (!leaveRequestId || !status) {
                    alertNotify('Please select status or employee leave', 'error');
                    return;
                }

                // Construct payload
                const payload = {
                    leave_request_id: leaveRequestId,
                    reporting_manager_id: getValue('reporting_manager_id'),
                    status,
                    reason: getValue('reason'),
                    leave_type_id: getValue('leave_type_id'),
                    number_of_days: getValue('number_of_days'),
                    applied_employee_id: getValue('applied_employee_id'),
                };

                // Prepare URL and AJAX options
                const url = "{{ url('leave/response-leave') }}";

                try {
                    // Make asynchronous AJAX request
                    const res = await ajaxRequest(url, payload, 'POST');

                    // Check response and display notification
                    if (res.status) {
                        alertNotify(res.message, 'success');
                    } else {
                        alertNotify(res.message || 'Something went wrong!', 'error');
                    }
                } catch (error) {
                    // Handle unexpected errors
                    console.error('Error in leave submission:', error);
                    alertNotify('An unexpected error occurred. Please try again later.', 'error');
                }
            }

            function submit1() {
                let leave_request_id = getValue('leave_request_id');
                let status = getValue('status');

                console.log('leave_request_id', leave_request_id);
                console.log('status', status);

                if (!leave_request_id || !status) {
                    alertNotify('Please select status or employee leave', 'error')
                    return
                }

                let url = "{{ url('leave/response-leave') }}";
                var payload = {
                    leave_request_id: getValue('leave_request_id'),
                    reporting_manager_id: getValue('reporting_manager_id'),
                    status: getValue('status'),
                    reason: getValue('reason'),
                    leave_type_id: getValue('leave_type_id'),
                    number_of_days: getValue('number_of_days'),
                    applied_employee_id: getValue('applied_employee_id'),
                };
                try {
                    let res = ajaxRequest(url, payload, 'POST');

                    if (res.status) {
                        alertNotify(res.message, 'success')
                    } else {
                        alertNotify(res.message, 'error')
                    }
                } catch (error) {
                    // Handle unexpected errors
                    console.error('Error in leave submission:', error);
                    alertNotify('An unexpected error occurred. Please try again later.', 'error');
                }
            }
        </script>
    @endpush


    @push('styles')
    @endpush
@endsection
