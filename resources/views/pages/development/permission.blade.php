@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="card" id="contactList">
                <div class="card-header py-2">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">{{ $title ?? '' }}</h5>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex gap-2">
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Search for transactions..." id="custom-search-input">
                                    <i class="ri-search-line search-icon"> </i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable-crud" class="display table-sm table stripe dt-responsive table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>First Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

        <script>
            function loadTable() {
                var table = $('#datatable-crud').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "scrollY": "50vh",
                    pageLength: 100,
                    ajax: {
                        url: '{{ url('development/permissions') }}',
                    },

                    columns: [{
                            data: 'name',
                            name: 'name',
                            // orderable: false,
                            // searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            // orderable: false,
                            // searchable: false
                        }
                    ]
                });

                $('#custom-search-input').keyup(function(e) {
                    var searchTerm = $(this).val();
                    table.search(searchTerm).draw();
                });

                let searchValue = $('#datatable_filter label input').val();
                $('#custom-search-input').val(searchValue);
            }

            function TrackingHistory(value) {
                const deviceIcon = getDeviceIcon(logedDevice.device); // Assuming getDeviceIcon is already defined
                const loginTime = new Date(logedDevice.login_time);
                const formattedTime = loginTime.toLocaleString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true,
                });

                const htmlString = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-light text-primary rounded-3" style="font-size:30px">
                                <i class="${deviceIcon}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6>${logedDevice.device}</h6>
                            <p class="text-muted mb-0">
                                User logged in successfully using
                                <b>${logedDevice.browser || ''}</b>
                                on a running
                                <b>${logedDevice.os}</b>
                                <b>${formattedTime}</b>
                                from the IP address <b>${logedDevice.ip_address}</b>
                            </p>
                        </div>
                    </div>
                `;

                return htmlString;

                return htmlString;
            }

            function getDeviceIcon(device) {
                const icons = {
                    'Mobile': 'ri-smartphone-line',
                    'Tablet': 'ri-tablet-line',
                    'Desktop': 'ri-computer-line',
                };

                return icons[device] || 'ri-question-line';
            }

            $(function() {
                loadTable();
                const element = document.querySelector('.dataTables_length label select');
                const choices = new Choices(element, {
                    searchEnabled: false
                });

            });
        </script>
    @endpush

    {{-- <style>
        #logged-user-datatable tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-style: none !important;
        }

        table.dataTable.table-sm .sorting_asc:before {
            display: none !important
        }

        table.dataTable.table-sm .sorting_asc:after {
            display: none !important
        }
    </style> --}}
@endsection
