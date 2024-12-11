@extends('layout.app')
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
                                <x-btn.add-btn isAdd="true" routeName="user.create" title="Create User" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable-crud" class="display table-sm table stripe dt-responsive table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Designation</th>
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
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function() {
                // console.log('jQuery:', typeof $);
                // console.log('DataTable:', $.fn.DataTable ? 'Loaded' : 'Not Loaded');


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
                        url: '{{ route('user.index') }}',
                        data: function(d) {
                            d.role = $('#choices-roles').val() || '-1';
                        }
                    },

                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'first_name',
                            name: 'first_name',
                            render: function(val, par2, row) {
                                if (row.last_name) {
                                    return val + ' ' + row?.last_name || '';
                                }
                                return val;
                            }
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'designation',
                            name: 'designation'
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            className: 'text-center',
                            render: function(value) {
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
