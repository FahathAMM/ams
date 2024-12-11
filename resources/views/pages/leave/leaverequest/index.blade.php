@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title ?? '' }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Leave</a></li>
                                <li class="breadcrumb-item active">{{ $title ?? '' }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-h-100">
                                <div class="card-body d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-12"style="max-width:800px;">
                                            <div id="calendar" classs="w-75"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style='clear:both'></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: "local",
                    editable: 0,
                    droppable: !0,
                    selectable: 1,
                    navLinks: !0,
                    initialView: "dayGridMonth",
                    themeSystem: "bootstrap",
                    events: @json($schedules), // Pass Laravel data to JS
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                        // right: "multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                    },
                    height: 'auto', // You can set it to a specific value like 600, or use 'auto' for dynamic resizing
                    contentHeight: 'auto', // Alternatively, you can control content height separately
                    width: '10%', // Set width to 100% of the parent container or a specific pixel value
                    dateClick: function(info) {
                        window.location.href = "{{ route('leave.create') }}?start=" + info.dateStr;
                    },
                    eventClick: function(info) {
                        // Redirect to the edit page
                        window.location.href = "{{ route('eod.list') }}/" +
                            '{{ currentUser()->employee->id }}';

                        // route('eod.list', ['id' => $emp->id])
                    },
                    select: function(selectionInfo) {
                        let startDate = selectionInfo.startStr; // Start date of the selection
                        let endDate = selectionInfo.endStr; // End date of the selection (exclusive)

                        // Example: Redirect to a Laravel route with start and end date as query parameters
                        window.location.href =
                            `{{ route('leave.create') }}?start=${startDate}&end=${endDate}`;


                        // Alternatively, display the selected dates
                        // alert("Selected range: " + startDate + " to " + endDate);
                    }
                });

                calendar.render();
            });
        </script>
    @endpush
@endsection
