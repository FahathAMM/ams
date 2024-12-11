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
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for transactions..."
                                    id="emp-search-input">
                                <i class="ri-search-line search-icon"> </i>
                            </div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">
                                <a href="{{ route('employee.index', ['layout' => 'grid']) }}" id="grid-view-button"
                                    class="btn btn-soft-info nav-link btn-icon fs-14 {{ $layout == 'grid' ? 'active' : '' }} filter-button">
                                    <i class="ri-grid-fill"></i>
                                </a>
                                <a href="{{ route('employee.index', ['layout' => 'list']) }}" id="list-view-button"
                                    class="btn btn-soft-info nav-link  btn-icon fs-14 filter-button {{ $layout == 'list' ? 'active' : '' }}">
                                    <i class="ri-list-unordered"></i>
                                </a>
                                @canOrRole('userpermission:organization-employee-create', 'create')
                                <a href="{{ route('employee.create') }}" class="btn btn-success">
                                    <i class="ri-add-fill me-1 align-bottom"></i>
                                    Add Members
                                </a>
                                @endcanOrRole


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if ($layout == 'grid')
                        <div>
                            <div id="teamlist" style="display: block;">
                                <div class="team-list row grid-view-filter" id="team-member-list">
                                    @forelse ($employees as $employee)
                                        <div class="col-lg-2 col-md-4 pb-3">
                                            <x-card.employee-view :data="$employee" :currentUser="$currentUser" :permissions="$permissions" />
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card" id="contactList">
                            <div class="card-body">
                                <table id="datatable-crud"
                                    class="display table-sm table stripe dt-responsive table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>EmployeeCode</th>
                                            <th>FullName</th>
                                            <th>Username</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Branch</th>
                                            <th>Department</th>
                                            {{-- <th>Status</th> --}}
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function() {
                console.log('hello');
                console.log('jQuery:', typeof $);
                console.log('DataTable:', $.fn.DataTable ? 'Loaded' : 'Not Loaded');

                loadTable();
                const element = document.querySelector('.dataTables_length label select');
                if (element) {
                    const choices = new Choices(element, {
                        searchEnabled: false
                    });
                }

            });

            function loadTable() {
                var table = $('#datatable-crud').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": true,
                    stateSave: true,
                    "scrollY": "50vh",
                    ajax: {
                        url: '{{ route('employee.index') }}', // Replace with your route
                        data: function(d) {
                            // Additional data you want to send to the server
                            d.role = $('#choices-roles').val() || '-1';
                        }
                    },

                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'emp_number',
                            name: 'emp_number'
                        },
                        {
                            data: 'full_name',
                            name: 'first_name'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'designation',
                            name: 'designation'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'branch.branch_name',
                            name: 'branch.branch_name',
                        },
                        {
                            data: 'department.department_name',
                            name: 'department.department_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                }); //end datatable

                $('#emp-search-input').keyup(function(e) {
                    var searchTerm = $(this).val();
                    table.search(searchTerm).draw(); // Use global search instead of column-specific search
                });

                let searchValue = $('#datatable_filter label input').val();
                $('#emp-search-input').val(searchValue);
            }
        </script>
    @endpush
@endsection
