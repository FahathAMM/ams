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
            {{-- <x-breadcrumb title="Users" parent="Administration" /> --}}
            <!-- end page title -->

            <div class="card" id="contactList">
                <div class="card-header py-2">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">{{ $title ?? '' }}</h5>
                        </div>
                        <!--end col-->

                        <!--end col-->
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex gap-2">
                                {{-- <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted flex-shrink-0">Sort by: </span>
                                    <select class="form-control mb-0" data-choices data-choices-search-false name="roles"
                                        id="choices-roles">
                                        <option value="-1" selected>All</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Admaasin">Adasasmin</option>
                                    </select>
                                </div> --}}
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Search for transactions..." id="custom-search-input">
                                    <i class="ri-search-line search-icon"> </i>
                                </div>
                                <x-btn.add-btn isAdd="true" routeName="asset.create" title="Create Asset" />
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <table id="datatable-crud" class="display table-sm table stripe dt-responsive table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Serial Number</th>
                                <th>Category</th>
                                <th>Assign Employee</th>
                                <th>Issue Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
            $(function() {

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
                    // "searching": true,
                    stateSave: true,
                    "scrollY": "50vh",
                    ajax: {
                        url: '{{ route('asset.index') }}', // Replace with your route
                        data: function(d) {
                            // Additional data you want to send to the server
                            d.role = $('#choices-roles').val() || '-1';
                        }
                    },
                    dataSrc: "data",

                    columns: [

                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'serial_number',
                            name: 'serial_number',
                        },
                        {
                            data: 'name',
                            name: 'category.name',
                        },

                        //     {
                        //     data: 'division_name1',
                        //     name: 'division.division_name1'
                        // },

                        // {
                        //     data: 'posts',
                        //     name: 'posts.title'
                        // },

                        {
                            data: 'employee.first_name',
                            name: 'employee.first_name',
                            render: function(val, par2, row) {
                                if (!val) return '';
                                const lastName = row?.last_name ?? '';
                                return `${val} ${lastName}`.trim();
                            }
                        },
                        {
                            data: 'issue_date',
                            name: 'issue_date',
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            className: 'text-center',
                            render: function(value) {
                                if (!value) {
                                    return ''
                                }
                                return ActiveStatus(value)
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                }); //end datatable

                // Your custom search logic
                $('#custom-search-input').keyup(function(e) {
                    var searchTerm = $(this).val();
                    table.search(searchTerm).draw(); // Use global search instead of column-specific search
                    // table.columns(1).search(searchTerm).draw(); // Assuming 'name' column index is 1
                });

                let searchValue = $('#datatable_filter label input').val();
                $('#custom-search-input').val(searchValue);
            }
        </script>
    @endpush
@endsection
