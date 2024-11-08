@extends('layout.app')
@section('title', $title)
@section('content')
    @push('styles')
        <!--datatable css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
        <!--datatable responsive css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            {{-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Team</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Team</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div> --}}
            <!-- end page title -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            {{-- <div class="search-box">
                                <input type="text" class="form-control" id="searchMemberList"
                                    placeholder="Search for name or designation...">
                                <i class="ri-search-line search-icon"></i>
                            </div> --}}
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for transactions..."
                                    id="emp-search-input">
                                <i class="ri-search-line search-icon"> </i>
                            </div>
                        </div>
                        <!--end col-->
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


                                {{-- <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                    aria-expanded="false" class="btn btn-soft-info btn-icon fs-14"><i
                                        class="ri-more-2-fill"></i></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                    <li><a class="dropdown-item" href="#">All</a></li>
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                                </ul> --}}


                                <a href="{{ route('employee.create') }}" class="btn btn-success">
                                    <i class="ri-add-fill me-1 align-bottom"></i>
                                    Add Members
                                </a>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
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
                                            <x-card.employee-view :data="$employee" />
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
        <!--datatable js-->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

        <script>
            // $(function() {
            //     loadTable();
            //     const element = document.querySelector('.dataTables_length label select');
            //     const choices = new Choices(element, {
            //         searchEnabled: false
            //     });
            // });

            $(document).ready(function() {
                console.log('hello');
                console.log('jQuery:', typeof $);
                console.log('DataTable:', $.fn.DataTable ? 'Loaded' : 'Not Loaded');


                loadTable();
                const element = document.querySelector('.dataTables_length label select');
                const choices = new Choices(element, {
                    searchEnabled: false
                });
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

                        // {
                        //     data: 'is_active',
                        //     name: 'is_active',
                        //     className: 'text-center',
                        //     render: function(value) {
                        //         // return value
                        //         return ActiveStatus(value)
                        //     }
                        // },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                }); //end datatable

                // Your custom search logic
                $('#emp-search-input').keyup(function(e) {
                    var searchTerm = $(this).val();
                    table.search(searchTerm).draw(); // Use global search instead of column-specific search
                    // table.columns(1).search(searchTerm).draw(); // Assuming 'name' column index is 1
                });

                let searchValue = $('#datatable_filter label input').val();
                $('#emp-search-input').val(searchValue);
            }
        </script>
    @endpush
@endsection
