@extends('layout.app')
@section('title', $title)
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
                @foreach ($roles as $role)
                    <div class="col-xxl-3 col-md-4">
                        <x-card.card-role :roleName="$role->name" color="warning" :roleId="$role->id" :item="$role"
                            btnTarget="editPermissionModal" funName="editPermissionModal"
                            per="administration-permission-edit" />
                    </div>
                @endforeach
            </div>

            <x-modal.common titleName="Edit Role" idName="editPermissionModal" size="modal-lg">
                <form action="#" method="POST" id="permission-edit-form" class="tablelist-form" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <x-input.hidden id="edit-role-id" />
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <x-input.txt-group label="Role Name" name="name" id="edit-name"
                                    placeholder="Enter your Role Name" readonly />
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">Assigned Permission</label>
                                <div data-simplebar style="height: 450px;">
                                    <div class="container">
                                        <div class="row">
                                            <table id="datatable-crud"
                                                class="display table-sm table stripe dt-responsive table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="header fixed-header per-module-header"
                                                            style="vertical-align: middle">
                                                            Module</th>
                                                        <th class="header fixed-header" style="vertical-align: middle"> Form
                                                        </th>
                                                        <th class="header fixed-header text-center">
                                                            Create <br>
                                                            <input class="form-check-input text-center" type="checkbox"
                                                                id="create-select-all-checkbox"
                                                                onclick="selectAll(this,'create-row-checkbox')">
                                                        </th>
                                                        <th class="header fixed-header">
                                                            Edit <br>
                                                            <input class="form-check-input" type="checkbox"
                                                                id="edit-select-all-checkbox"
                                                                onclick="selectAll(this,'edit-row-checkbox')">
                                                        </th>
                                                        <th class="header fixed-header">
                                                            View <br>
                                                            <input class="form-check-input" type="checkbox"
                                                                id="view-select-all-checkbox"
                                                                onclick="selectAll(this,'view-row-checkbox')">
                                                        </th>
                                                        <th class="header fixed-header">
                                                            Delete <br>
                                                            <input class="form-check-input" type="checkbox"
                                                                id="delete-select-all-checkbox"
                                                                onclick="selectAll(this,'delete-row-checkbox')">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
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
                            <button type="button" class="btn btn-success sbtBtn" onclick="update()">Submit</button>
                        </div>
                    </div>
                </form>
            </x-modal.common>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

        <script>
            function userPermissionTable(permissionBy = "", roleId = "", moduleList = []) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#datatable-crud').DataTable().destroy();

                $('#datatable-crud').DataTable({
                    paging: false,
                    searching: false,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ajax: {
                        url: "{{ url('administration/permission') }}",
                        type: "GET",
                        data: function(d) {
                            d.permissionBy = permissionBy;
                            d.roleId = roleId || 1;
                            d.moduleList = moduleList;
                        }
                    },

                    dataSrc: "data",
                    columns: [{
                            data: 'moduleName',
                            name: 'moduleName',
                            orderable: false,
                            render: function(value) {
                                return ` <label class="form-check-label d-flex align-items-center" for="edit-1"> <span class="flex-shrink-0"></span> <span class="flex-grow-1 ms-2">${value}</span> </label>`
                            }
                        },
                        {
                            data: 'form',
                            name: 'form',
                            orderable: false,
                            render: function(value) {
                                return ` <label class="form-check-label d-flex align-items-center" for="edit-1"> <span class="flex-shrink-0"></span> <span class="flex-grow-1 ms-2">${value}</span> </label>`
                            }
                        },
                        {
                            data: 'create',
                            name: 'create',
                            orderable: false
                        },
                        {
                            data: 'edit',
                            name: 'edit',
                            orderable: false
                        },
                        {
                            data: 'view',
                            name: 'view',
                            orderable: false
                        },
                        {
                            data: 'delete',
                            name: 'delete',
                            orderable: false
                        },
                    ],

                    initComplete: function(settings, json) {
                        loadSelectAllCheck();
                    }
                });
                $('.dt-area').removeClass('d-none');
            }

            function getFormsByModule(val) {
                let userorusertypelist = getValue('userorusertypelist');

                $('.dt-area').addClass('d-none');
                var checkedValues = [];
                $("input[name='modules[]']:checked").each(function() {
                    checkedValues.push($(this).val());
                });
            }

            function selectAll(res, className) {
                var isChecked = $(res).prop('checked');
                $(`.${className}`).prop('checked', isChecked);
            }

            function unselectAll(res, className, headerCheckbox) {
                updateSelectAllCheckbox(className, headerCheckbox);
            }

            function updateSelectAllCheckbox(className, headerCheckbox) {
                var totalRows = $(`.${className}`).length;
                var checkedRows = $(`.${className}:checked`).length;
                $(`#${headerCheckbox}`).prop('checked', checkedRows === totalRows);
            }

            function loadSelectAllCheck() {
                ['create', 'edit', 'view', 'delete', 'export'].map(access => updateSelectAllCheckbox(
                    `${access}-row-checkbox`, `${access}-select-all-checkbox`));
            }

            $(document).ready(function() {
                getFormsByModule(null)
            });

            function editPermissionModal(roleId, item) {
                setValue('edit-name', item.name);
                setValue('edit-role-id', roleId);
                userPermissionTable(null, roleId, null)
                $("#editPermissionModal").fadeIn(500, function() {
                    $(this).modal("show");
                });
            }

            function update() {
                console.log('udpat');

                sLoading('sbtBtn')
                let roleId = getValue('edit-role-id');
                var form = document.getElementById('permission-edit-form');
                var url = '{{ url('administration/permission') }}/' + roleId;
                var method = 'PUT';

                const options = {
                    contentType: 'application/json',
                    method: method || 'POST',
                    headers: {
                        dataType: "json",
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };

                var rowData = [];
                $('#datatable-crud tbody tr').each(function() {
                    var $row = $(this);
                    var MenuId = $row.find('#MenuId').val();
                    var MenuDetailId = $row.find('#MenuDetailId').val();
                    var subMenuDetailId = $row.find('#subMenuDetailId').val();
                    var subMenuDetailId = $row.find('#subMenuDetailId').val();
                    var MenuName = $row.find('#MenuName').val();
                    var ModuleName = $row.find('#ModuleName').val();
                    var MenuSlug = $row.find('#MenuSlug').val();

                    var permissons = ['create', 'edit', 'view', 'delete', 'export'];
                    var permissonValues = {};

                    permissons.forEach(function(per) {
                        // var isChecked = $row.find('.' + per + '-row-checkbox').prop('checked');
                        let Checked = $row.find('.' + per + '-row-checkbox');
                        let isChecked = Checked.prop('checked')
                        permissonValues[per + 'Value'] = isChecked ? Checked.val() : 0;
                        permissonValues['MenuId'] = MenuId;
                        permissonValues['MenuDetailId'] = MenuDetailId;
                        permissonValues['subMenuDetailId'] = subMenuDetailId;
                        permissonValues['MenuName'] = MenuName;
                        permissonValues['ModuleName'] = ModuleName;
                        permissonValues['MenuSlug'] = MenuSlug;
                    });

                    rowData.push({
                        ...permissonValues
                    });
                });

                var payload = {
                    rowData,
                    roleId: roleId,
                };

                console.log(payload);
                sendData(
                    url,
                    payload,
                    options,
                    (response) => {
                        if (response.status) {
                            eLoading('sbtBtn')
                            closeModal('editPermissionModal');
                            alertNotify(response.message, 'success')
                        } else {
                            console.log(response.errors);
                            eLoading('sbtBtn')
                        }
                    },
                    (error) => {
                        console.error('Error:', error);
                    }
                );
            }
        </script>
    @endpush
@endsection
