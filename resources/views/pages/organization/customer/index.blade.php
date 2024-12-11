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
            <div class="card" id="customerList">
                <div class="card-header py-2">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">{{ $title ?? 'Customer Management' }}</h5>
                        </div>

                        <div class="col-md-auto ms-auto">
                            <div class="d-flex gap-2">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Search for customers..."
                                        id="custom-search-input">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                                @canOrRole('userpermission:organization-employee-create', 'create')
                                <x-btn.add-btn isAdd="true" routeName="customer.create" title="Create Customer" />
                                @endcanOrRole
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable-crud" class="display table-sm table stripe dt-responsive table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Customer Code</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
                    stateSave: true,
                    "scrollY": "50vh",
                    ajax: {
                        url: '{{ route('customer.index') }}', // Replace with your customer index route
                        data: function(d) {
                            d.role = $('#choices-roles').val() || '-1';
                        }
                    },
                    columns: [{
                            data: 'customer_code',
                            name: 'customer_code'
                        },
                        {
                            data: 'first_name',
                            name: 'first_name'
                        },
                        {
                            data: 'last_name',
                            name: 'last_name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            className: 'text-center',
                            render: function(value) {
                                return value ? 'Active' : 'Inactive';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
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
        </script>
    @endpush
@endsection
