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
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Search for transactions..." id="custom-search-input">
                                    <i class="ri-search-line search-icon"> </i>
                                </div>
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
                                <th>ID</th>
                                <th>Username</th>
                                <th>FormName</th>
                                <th>FormCode</th>
                                <th>ActivityOn</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


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

            function formAction(value) {
                // const arr = {
                //     Create: 'bg-success',
                //     Update: 'bg-primary',
                //     Delete: 'bg-danger',
                // }

                const arr = {
                    Create: 'badge bg-success',
                    Update: 'badge bg-primary',
                    Delete: 'badge bg-danger',
                }

                return `<h5 class="fs-14 my-1 fw-normal"> <span class="badge  ${arr[value]}"> ${value} </span> </h5>`

                // return `<p class="p-0 m-0 rounded text-center ${arr[value]}" style="width:30%; margin: 0 auto !important;"> <span class="text-white py-0"> ${value} </span> </p>`;
            }

            function loadTable() {
                var table = $('#datatable-crud').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": true,
                    // stateSave: true,
                    "scrollY": "50vh",
                    pageLength: 100,
                    ajax: {
                        url: '{{ url('administration/user-activity') }}', // Replace with your route
                        data: function(d) {
                            // Additional data you want to send to the server
                            d.role = $('#choices-roles').val() || '-1';
                        }
                    },

                    columns: [{
                            data: 'id',
                            name: 'id',

                        },
                        {
                            data: 'user_name',
                            name: 'user_name',

                        },
                        {
                            data: 'form_name',
                            name: 'form_name'
                        },
                        {
                            data: 'form_record_id',
                            name: 'form_record_id'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'log_action',
                            name: 'log_action',
                            render: function(value) {
                                return formAction(value)
                            }
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
