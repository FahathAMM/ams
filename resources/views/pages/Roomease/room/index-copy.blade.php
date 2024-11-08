@extends('layout.app')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
        <!--datatable responsive css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

        <style>
            table.dataTable tr {
                border: 2px solid #dbdade;
            }

            table.dataTable {
                border-top: 1px solid #dbdade;
                border-right: 1px solid #dbdade;
                border-left: 1px solid #dbdade;
            }
        </style>
    @endpush
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <x-breadcrumb title="Role" parent="Page" />
            <!-- end page title -->

            <div class="row" id="role-card-area">
                @foreach ($roles as $role)
                    <div class="col-xxl-3 col-md-6">
                        <x-card.card-role :roleName="$role->name" color="warning" />
                        <!--end card-->
                    </div>
                @endforeach
                <div class="col-xxl-3 col-md-6">
                    <x-card.card-add-role color="success" />
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

            <x-modal.modal-new-role />

            <div class="card mt-3" id="contactList">
                <div class="card-header">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">Role Assigned Users</h5>
                        </div>
                        <!--end col-->

                        <!--end col-->
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted flex-shrink-0">Sort by: </span>
                                    <select class="form-control mb-0" data-choices data-choices-search-false name="roles"
                                        id="choices-roles">
                                        <option value="-1" selected>All</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Admaasin">Adasasmin</option>
                                    </select>
                                </div>
                                <div class="search-box">
                                    <input type="text" class="form-control search"
                                        placeholder="Search for transactions..." id="custom-search-input">
                                    <i class="ri-search-line search-icon"> </i>
                                </div>
                                <button class="btn btn-success" id="custom-search-btn">
                                    <i class="ri-equalizer-line align-bottom me-1"></i>
                                    Filters
                                </button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <table id="role-table" class="display table-sm table stripe dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
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
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script>
            $(function() {
                loadTable();

                const element = document.querySelector('.dataTables_length label select');
                const choices = new Choices(element, {
                    searchEnabled: false
                });

            });

            function loadTable() {
                var table = $('#role-table').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": true,
                    stateSave: true,

                    ajax: {
                        url: '{{ route('role.index') }}', // Replace with your route
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'roles',
                            name: 'roles',
                            render: function(data) {
                                return data.map(role => role.name).join(', ');
                            },
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
                $('#custom-search-btn').on('click', function() {
                    var searchTerm = $('#custom-search-input').val();
                    table.columns(1).search(searchTerm).draw(); // Assuming 'name' column index is 1
                });

                let searchValue = $('#role-table_filter label input').val();
                $('#custom-search-input').val(searchValue);
            }


            // ========form submit============
            $('#addRoleModal').submit(function(e) {
                var $form = $(this);
                e.preventDefault(); // keeps the form from behaving like a normal (non-ajax) HTML form
                var url = $form.attr('action');
                var formData = {};

                // submit a POST request with the form data
                $form.find('input, select').each(function() {
                    formData[$(this).attr('name')] = $(this).val();
                });

                // submits an array of key-value pairs to the form's action URL
                $.post(url, formData, function(response) {
                    // handle successful validation
                    $("#role-card-area").load(location.href + " #role-card-area");
                    $('#addRoleModal').modal('hide');

                }).fail(function(response) {
                    // handle failed validation
                    associate_errors(response.responseJSON.errors, $form);
                });
            });

            function associate_errors(errors, $form) {
                // remove existing error classes and error messages from form groups
                $form.find('.form-group').find('.invalid-msg').text('');
                $form.find('.form-group').find('.form-control').removeClass('is-invalid');

                // iterate over the keys of the error object
                Object.keys(errors).forEach(function(fieldName) {
                    // find each form group, which is given a unique id based on the form field's name
                    var $group = $form.find('[name="' + fieldName + '"]');

                    // add the error class and set the error text
                    $group.addClass('is-invalid');
                    $group.closest('.form-group').find('.invalid-msg').text(errors[fieldName][0]);
                });
            }
        </script>
    @endpush
@endsection
