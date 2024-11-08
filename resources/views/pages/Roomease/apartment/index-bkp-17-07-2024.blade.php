@extends('layout.app')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
        <!--datatable responsive css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @endpush
    <div class="page-content">
        <div class="container-fluid">

            <div class="row" id="role-card-area">
                {{-- <div class="row" id="area-my"> --}}
                @foreach ($roles as $role)
                    <div class="col-xxl-2 col-md-4">
                        <x-card.card-role :roleName="$role->name" color="warning" :roleId="$role->id" :item="$role" />
                    </div>
                @endforeach
                <div class="col-xxl-2 col-md-4">
                    <x-card.card-add-role color="success" />
                </div>
            </div>

            {{-- @dd($users); --}}

            {{-- add role  modal --}}
            <x-modal.common titleName="Add Role" idName="addRoleModal" size="modal-lg">
                <form action="{{ route('role.store') }}" method="POST" id="role-form" class="tablelist-form"
                    autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <x-input.txt-group label="Role Name" name="name" placeholder="Enter your Role Name" />
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Assigned To</label>
                                <div data-simplebar style="height: 400px;">
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($users->chunk(ceil($users->count() / 4)) as $userChunk)
                                                <div class="col-lg-3 col-md-6">
                                                    <ul class="list-unstyled vstack gap-2 mb-0">
                                                        @foreach ($userChunk as $user)
                                                            <li>
                                                                <div class="form-check d-flex align-items-center">
                                                                    <input class="form-check-input me-3" type="checkbox"
                                                                        name="assignedTo[]" value="{{ $user->id }}"
                                                                        id="{{ $user->id }}">
                                                                    <label
                                                                        class="form-check-label d-flex align-items-center"
                                                                        for="{{ $user->id }}">
                                                                        <span class="flex-shrink-0">
                                                                            <img src="{{ $user->img }}" alt=""
                                                                                class="avatar-xxs rounded-circle">
                                                                        </span>
                                                                        <span
                                                                            class="flex-grow-1 ms-2">{{ $user->first_name }}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="store()" id="add-btn">Submit</button>
                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
                        </div>
                    </div>
                </form>
            </x-modal.common>


            {{-- edit role  modal --}}
            <x-modal.common titleName="Edit Role" idName="editRoleModal" size="modal-lg">
                <form action="#" method="POST" id="role-edit-form" class="tablelist-form" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <x-input.hidden id="edit-role-id" />
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <x-input.txt-group label="Role Name" name="name" id="edit-name"
                                    placeholder="Enter your Role Name" />
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">Assigned To</label>
                                <div data-simplebar style="height: 400px;">
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($users->chunk(ceil($users->count() / 4)) as $userChunk)
                                                <div class="col-lg-3 col-md-6">
                                                    <ul class="list-unstyled vstack gap-2 mb-0">
                                                        @foreach ($userChunk as $user)
                                                            <li>
                                                                <div class="form-check d-flex align-items-center">
                                                                    <input class="form-check-input me-3" type="checkbox"
                                                                        name="assignedTo[]" value="{{ $user->id }}"
                                                                        id="edit-{{ $user->id }}">
                                                                    <label
                                                                        class="form-check-label d-flex align-items-center"
                                                                        for="edit-{{ $user->id }}">
                                                                        <span class="flex-shrink-0">
                                                                            <img src="{{ $user->img }}" alt=""
                                                                                class="avatar-xxs rounded-circle">
                                                                        </span>
                                                                        <span
                                                                            class="flex-grow-1 ms-2">{{ $user->first_name }}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="update()"
                                id="add-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </x-modal.common>
            {{-- <div id="area-my" class="bg-danger">
                sss
            </div> --}}
            <div class="card" id="contactList">
                <div class="card-header py-2">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">{{ $title ?? '' }}</h5>
                        </div>

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
                        <!--end col-->
                    </div>
                </div>
                <!--end card-header-->
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
                <!--end card-body-->
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(function() {
                // loadTable();
                const element = document.querySelector('.dataTables_length label select');
                if (element) {
                    const choices = new Choices(element, {
                        searchEnabled: false
                    });
                }
            });

            function editRoleModal(roleId, item) {
                console.log(item);
                $(`#editRoleModal input:checkbox`).prop('checked', false);
                item.users.forEach(e => {
                    $(`#edit-${e.id}`).prop('checked', true);
                });
                setValue('edit-name', item.name);
                setValue('edit-role-id', roleId);
            }

            function store() {
                console.log('form store');
                var form = document.getElementById('role-form');
                var url = form.getAttribute('action');
                var method = form.getAttribute('method');
                var payload = new FormData(form);
                console.log(payload);

                const options = {
                    contentType: 'application/json',
                    // 'Content-Type': 'multipart/form-data',
                    method: 'POST',
                    headers: {
                        dataType: "json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        console.log('Success:', response.status);
                        if (response.status) {
                            $("#role-form :input").val("");
                            // redirectTo('{{ route('user.index') }}');
                            refreshContent('role', 'role-card-area')
                            closeModal('addRoleModal');
                            alertNotify(response.message, 'success')
                        } else {
                            associateErrors(response.errors, 'role-form');
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }

            function update() {
                let roleId = getValue('edit-role-id');
                var form = document.getElementById('role-edit-form');
                // var url = '{{ url('role') }}/' + roleId + '/edit';
                var url = '{{ url('role') }}/' + roleId;
                var method = form.getAttribute('method');
                var payload = new FormData(form);

                const options = {
                    contentType: 'application/json',
                    // 'Content-Type': 'multipart/form-data',
                    method: 'POST',
                    headers: {
                        dataType: "json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        if (response.status) {
                            refreshContent('role', 'role-card-area')
                            closeModal('editRoleModal');
                            alertNotify(response.message, 'success')
                        } else {
                            associateErrors(response.errors, 'role-edit-form');
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }


            function closeModal(modalId) {
                $(`#${modalId}`).modal('hide');
            }

            function refreshContent(pageUrl = "", area = "") {
                var xhr = new XMLHttpRequest();
                let currentUrl = pageUrl;
                var url = `{{ url('${currentUrl}') }}`;

                xhr.open('GET', url, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        var responseHTML = xhr.responseText;

                        // Create a temporary element to parse the response HTML
                        var tempElement = document.createElement('div');
                        tempElement.innerHTML = responseHTML;

                        // Find the specific div you want to replace
                        var newContent = tempElement.querySelector(`#${area}`).innerHTML;

                        // Replace the content of #area-my with the new content
                        document.getElementById(`${area}`).innerHTML = newContent;
                    } else {
                        console.error('Request failed with status:', xhr.status);
                    }
                };

                xhr.send();
            }


            function loadTable() {
                var table = $('#datatable-crud').DataTable({
                    processing: true,
                    serverSide: true,
                    "searching": true,
                    stateSave: true,
                    "scrollY": "50vh",
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
                            data: 'first_name',
                            name: 'first_name',
                            render: function(val, par2, row) {
                                if (row.last_name) {
                                    return val + ' ' + row?.last_name || '';
                                }
                                return val;
                                // console.log(row.first_name, val);
                                // console.log(typeof row.last_name, val);
                            }
                        },
                        // {
                        //     data: 'email_verified_at',
                        //     name: 'email_verified_at',
                        //     render: function(val, par2, row) {
                        //         console.log(typeof val);
                        //         return val
                        //     }
                        // },
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
                                // return value
                                return ActiveStatus(value)
                            }
                        },
                        // {
                        //     data: 'roles',
                        //     name: 'roles',
                        //     render: function(data) {
                        //         return data.map(role => role.name).join(', ');
                        //     },
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
                $('#custom-search-input').keyup(function(e) {
                    var searchTerm = $(this).val();
                    table.search(searchTerm).draw(); // Use global search instead of column-specific search
                    // table.columns(1).search(searchTerm).draw(); // Assuming 'name' column index is 1
                });

                let searchValue = $('#datatable_filter label input').val();
                $('#custom-search-input').val(searchValue);
            }


            // ========form submit============
        </script>
    @endpush
@endsection
