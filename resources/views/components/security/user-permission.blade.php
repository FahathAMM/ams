 <style>
     .form-control {
         height: 40% !important;
         padding: .30rem .55rem !important;
     }

     .focus-none:focus {
         box-shadow: none !important;
         border-color: none !important;
         -webkit-box-shadow: none !important;
     }

     .header {
         position: sticky;
         top: -1px;
         font-size: 12px !important
     }

     .user-dt-body tr td:not(:nth-child(-n+2)),
     #datatable-crud thead tr th:not(:nth-child(-n+2)) {
         text-align: center !important;
     }
 </style>

 @section('css')
     <!-- plugin css -->
     <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ URL::asset('/assets/libs/datepicker/datepicker.min.css') }}">
     <link href="{{ URL::asset('/assets/css/select2.min.css') }}" rel="stylesheet" />
     <!-- DataTables -->
     <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
 @endsection


 <div class="row">
     {{-- <x-hidden-input name="userorusertypelist" id="userorusertypelist" :value="$role" /> --}}
     <div class="col-md-4 col-12">
         <div class="row py-3">
             @foreach ($modules as $module)
                 <div class="col-md-12 col-12">
                     <div class="input-group mt-2">
                         <div class="input-group">
                             <label class="col-sm-4 form-check-label w-50" for="{{ $module->menuname1 }}">
                                 {{ $module->menuname1 }}
                             </label>
                             <input onchange="getFormsByModule(this.value)" value="{{ $module->menuid }}"
                                 class="form-check-input mt-2" name="modules[]" type="checkbox"
                                 id="{{ $module->menuname1 }}">
                         </div>
                     </div>
                 </div>
             @endforeach
             <div class="col-md-6 col-12">
                 <div class="input-group mt-2">
                     <div class="input-group">
                         <button type="button" class="btn py-1 w-50 bg-success text-white border-success waves-effect"
                             onclick="store(this)" title="Save" id="permstoreBtn">
                             <i class="far fa-save"></i>
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-md-8 col-12">
         <div style="max-height: 500px;overflow-y: scroll" class="row dt-area mt-4 d-none1">
             <table id="datatable-crud" class="table table-bordered dt-responsive nowrap" style="width: 100%">
                 <thead>
                     <tr>
                         <th class="header" style="vertical-align: middle">
                             Module</th>
                         <th class="header" style="vertical-align: middle">
                             Form</th>
                         <th class="header text-center">
                             Create <br>
                             <input class="form-check-input" type="checkbox" id="create-select-all-checkbox"
                                 onclick="selectAll(this,'create-row-checkbox')">
                         </th>
                         <th class="header">
                             Edit <br>
                             <input class="form-check-input" type="checkbox" id="edit-select-all-checkbox"
                                 onclick="selectAll(this,'edit-row-checkbox')">
                         </th>
                         <th class="header">
                             View <br>
                             <input class="form-check-input" type="checkbox" id="view-select-all-checkbox"
                                 onclick="selectAll(this,'view-row-checkbox')">
                         </th>
                         <th class="header">
                             Delete <br>
                             <input class="form-check-input" type="checkbox" id="delete-select-all-checkbox"
                                 onclick="selectAll(this,'delete-row-checkbox')">
                         </th>
                         <th class="header" style="vertical-align: middle">
                             Export <br>
                             <input class="form-check-input" type="checkbox" id="export-select-all-checkbox"
                                 onclick="selectAll(this,'export-row-checkbox')">
                         </th>
                     </tr>
                 </thead>
                 <tbody class="user-dt-body"></tbody>
             </table>
         </div>
     </div>
 </div>

 @push('scripts')
     <script>
         function store() {

             let permission_by = getValue('permission_by');
             let userorusertype = getValue('userorusertypelist');

             if (!userorusertype) {
                 alert('select user/type');
                 return;
             }

             formBtnSLoading('permstoreBtn');

             var rowData = [];
             $('#datatable-crud tbody tr').each(function() {
                 var $row = $(this);
                 var MenuId = $row.find('#MenuId').val();
                 var MenuDetailId = $row.find('#MenuDetailId').val();
                 var subMenuDetailId = $row.find('#subMenuDetailId').val();
                 var subMenuDetailId = $row.find('#subMenuDetailId').val();
                 var MenuName = $row.find('#MenuName').val();
                 var ModuleName = $row.find('#ModuleName').val();

                 var permissons = ['create', 'edit', 'view', 'delete', 'export'];
                 var permissonValues = {};

                 permissons.forEach(function(per) {
                     var isChecked = $row.find('.' + per + '-row-checkbox').prop('checked');
                     permissonValues[per + 'Value'] = isChecked ? 1 : 0;
                     permissonValues['MenuId'] = MenuId;
                     permissonValues['MenuDetailId'] = MenuDetailId;
                     permissonValues['subMenuDetailId'] = subMenuDetailId;
                     permissonValues['MenuName'] = MenuName;
                     permissonValues['ModuleName'] = ModuleName;
                 });

                 rowData.push({
                     permission_by: permission_by,
                     userorusertype: userorusertype,
                     ...permissonValues
                 });
             });

             setTimeout(() => {
                 console.log('end');
                 formBtnELoading('permstoreBtn');
             }, 2000);


             let payload = {
                 data: rowData,
             }
             let endpoint = "{{ url('administration/userpermission') }}";
             let res = ajaxJsonRequest(endpoint, payload, 'POST');

             if (res.status) {
                 if (res.isCurrentUser) {
                     window.location.href = "{{ url('login') }}";
                     return;
                 }
                 setTimeout(() => {
                     formBtnELoading('permstoreBtn');
                     sAlert(res.msg, 'success')
                 }, 2000);
             }
         }

         function userPermissionTable(permissionBy = "", userOrUsertype = "", moduleList = []) {
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
                     url: "{{ url('administration/userpermission') }}",
                     type: "GET",
                     data: function(d) {
                         d.permissionBy = permissionBy;
                         d.userOrUsertype = userOrUsertype;
                         d.moduleList = moduleList;
                     }
                 },

                 dataSrc: "data",
                 columns: [{
                         data: 'moduleName',
                         name: 'moduleName',
                         orderable: false,
                     },
                     {
                         data: 'form',
                         name: 'form',
                         orderable: false
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
                         name: 'viewd',
                         orderable: false
                     },
                     {
                         data: 'delete',
                         name: 'delete',
                         orderable: false
                     },
                     {
                         data: 'export',
                         name: 'export',
                         orderable: false
                     },
                 ],
                 order: [
                     // [4, 'asc']
                 ],
                 initComplete: function(settings, json) {
                     loadSelectAllCheck();
                 }
             });
             $('.dt-area').removeClass('d-none');
         }

         function getFormsByModule(val) {
             let userorusertypelist = getValue('userorusertypelist');

             if (!userorusertypelist) {
                 alert('select user/type');
                 return;
             }

             $('.dt-area').addClass('d-none');
             var checkedValues = [];
             $("input[name='modules[]']:checked").each(function() {
                 checkedValues.push($(this).val());
             });
             userPermissionTable(getValue('permission_by'), getValue('userorusertypelist'), checkedValues)
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
             $('.select2').select2();
             $(".select2").select2({
                 dropdownPosition: 'below'
             });
         });
     </script>

     <link href="{{ URL::asset('/assets/css/select2.min.css') }}" rel="stylesheet" />
     <script src="{{ URL::asset('/assets/js/select2.min.js') }}"></script>
     <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
     <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
     <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
 @endpush
