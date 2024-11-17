@extends('layout.app')
@section('title', $title ?? '')
@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        {{ $title }}
                    </h5>
                </div>
                <form action="{{ route('setting.store') }}" id="setting-form" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row pb-2">
                            <div class="col-lg-6">
                                <div style=" border: 1px solid #e2e3ea; padding: 20px 10px; border-radius: 5px; "
                                    class="mt-3 h-100 mb-0">
                                    <legend class="fs-14"
                                        style="position: relative;background: white;width: auto;top: -32px;padding: 0px 10px;border: 1px solid #e2e3ea;border-radius: 6px;">
                                        Notification
                                    </legend>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12 col-xxl-12">
                                            <table class="table table-sm table-nowrap  table-borderless">
                                                <tbody>
                                                    @foreach ($settings as $setting)
                                                        <tr>
                                                            <th class="w-25">
                                                                <label class="mb-0">
                                                                    {{ $setting->key_name }}
                                                                </label>
                                                            </th>
                                                            <td>
                                                                @if ($setting->type == 'text')
                                                                    <input type="text" name="{{ $setting->key }}"
                                                                        id="{{ $setting->key }}"
                                                                        placeholder="enter the value"
                                                                        value="{{ $setting->value }}"
                                                                        class="form-control form-control-sm mx-4"
                                                                        autocomplete="off">
                                                                @elseif ($setting->type == 'select')
                                                                    @php
                                                                        $items = explode(',', $setting->type_value);
                                                                    @endphp

                                                                    <select class="form-select form-select-sm mx-4"
                                                                        name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                                        data-chofices data-choices-search-false>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($items as $item)
                                                                            <option value="{{ $item }}"
                                                                                {{ $item == $setting->value ? 'selected' : '' }}>
                                                                                {{ $item }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch form-switch-md ms-5"
                                                                    dir="ltr">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="createShipment" value="1"
                                                                        name="{{ $setting->key . '_is_active' }}"
                                                                        @checked($setting->is_active)
                                                                        title="{{ !$setting->is_active ? 'Active' : 'Inactive' }}">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div style=" border: 1px solid #e2e3ea; padding: 20px 10px; border-radius: 5px; "
                                    class="mt-3 h-100 mb-0">
                                    <legend class="fs-14"
                                        style="position: relative;background: white;width: auto;top: -32px;padding: 0px 10px;border: 1px solid #e2e3ea;border-radius: 6px;">
                                        Schedule Time
                                    </legend>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12 col-xxl-12">
                                            <table class="table table-sm" id="schedule-table">
                                                <thead>
                                                    <th>Name</th>
                                                    <th>Last Start Time</th>
                                                    <th>Last End Time</th>
                                                    <th>Next Due</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cronSchedules as $schedule)
                                                        <tr>
                                                            <th class="w-25">
                                                                <label class="mb-0 my-1">
                                                                    {{ $schedule->name }}
                                                                </label>
                                                            </th>
                                                            <td>
                                                                <label class="mb-0 my-1">
                                                                    {{ $schedule->last_started_at }}
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <label class="mb-0 my-1">
                                                                    {{ $schedule->last_finished_at }}
                                                                </label>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $cron = new \Cron\CronExpression(
                                                                        $schedule->cron_expression,
                                                                    );

                                                                    // Get the next run date
                                                                    $nextRun = $cron
                                                                        ->getNextRunDate()
                                                                        ->format('Y-m-d H:i:s');

                                                                    // Calculate the time difference in seconds
                                                                    $remainingSeconds = \Carbon\Carbon::now()->diffInSeconds(
                                                                        $cron->getNextRunDate(),
                                                                    );

                                                                    // Determine how to display the time
                                                                    if ($remainingSeconds < 60) {
                                                                        $remainingTime = $remainingSeconds . ' sec';
                                                                    } elseif ($remainingSeconds < 3600) {
                                                                        $remainingMinutes = floor(
                                                                            $remainingSeconds / 60,
                                                                        );
                                                                        $remainingTime = $remainingMinutes . ' min';
                                                                    } else {
                                                                        $remainingHours = floor(
                                                                            $remainingSeconds / 3600,
                                                                        );
                                                                        $remainingTime = $remainingHours . ' hour';
                                                                    }
                                                                @endphp

                                                                <label class="mb-0">
                                                                    Next in
                                                                    <label class="fs-14 my-1 fw-normal">
                                                                        <span class="badge bg-success-subtle text-success">
                                                                            {{ $remainingTime }}
                                                                        </span>
                                                                    </label>
                                                                    from now
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary" id="sbtBtn"
                                    onclick=" sLoading('sbtBtn'); document.getElementById('setting-form').submit(); ">
                                    Submit
                                </button>
                                <button type="button" class="btn btn-soft-success">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Function to refresh the table
            function refreshTable() {
                fetch("{{ url('administration/setting') }}")
                    .then(response => response.text())
                    .then(html => {
                        // Create a temporary DOM element to hold the response
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Extract the content of the specific div by its id (e.g., 'schedule-table')
                        const newTableContent = doc.getElementById('schedule-table').innerHTML;

                        // Replace the existing table content with the new content
                        document.getElementById('schedule-table').innerHTML = newTableContent;
                    })
                    .catch(error => {
                        console.error('Error fetching the updated table:', error);
                    });
            }

            // Auto-refresh every 10 seconds
            setInterval(refreshTable, 10000);
        </script>
    @endpush

    <style>
        .choices__list--dropdown {
            width: 100% !important;
        }

        .table .form-select:focus {
            box-shadow: none !important;
        }
    </style>

@endsection
