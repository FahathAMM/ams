public function index(Request $request)
{
// return currentUser();
// generateMenuSlug();


// Get the authenticated user
$user = auth()->user();

// Ensure the user has multiple roles

// Retrieve permissions via roles
$permissions = $user->getPermissionsViaRoles();

// Check the permissions
// return $permissions;




$user = auth()->user();
$roles = $user->getPermissionsViaRoles();

[
'getRoleNames' => $roles = $user->roles, // Returns a collection
// get a list of all permissions directly assigned to the user
// 'getPermissionNames' => $user->getPermissionNames(), // collection of name strings
// 'permissions' => $user->permissions, // collection of permission objects
// // get all permissions for the user, either directly, or from roles, or from both
'getDirectPermissions' => $user->getDirectPermissions(),
// 'getPermissionsViaRoles' => $user->getPermissionsViaRoles(),

// 'getPermissionsViaRolesCount' => count($user->getPermissionsViaRoles()),
// 'getAllPermissionsCount' => count($user->getAllPermissions()),
// 'getAllPermissions' => $user->getAllPermissions(),

// get the names of the user's roles

];

// return $roles = $user->roles; // This retrieves all roles assigned to the user

// return $data = User::with('roles')->get();
// $model = User::query();

// if ($request->has('role') && $request->role != -1) {
// $model->whereHas('roles', function ($q) use ($request) {
// $q->where('name', $request->role);
// });
// }
// $result = $model->with('roles')->get();
$model = MenuHeader::query();

$menus = $model
->select(
'menu_headers.id as menuid',
'menu_headers.name1 as menuname1',
'md.id as menudetailid',
'md.name1 as menudetailname1',
'md.is_submenu_available',
'msd.id as submenudetailid',
'msd.name1 as submenudetailname1',
'md.sequence as menusequence',
'msd.sequence as submenusequence',
'msd.menu_slug as menu_sub_slug',
'md.menu_slug as menu_d_slug',
)
->leftJoin('menu_details as md', 'menu_headers.id', '=', 'md.menu_header_id')
->leftJoin('menu_sub_details as msd', 'md.id', '=', 'msd.menu_detail_id')->orderBy('md.id', 'asc')->get();


$menus_arr = [];

foreach ($menus as $menu) {
if ($menu->menuname1 == 'Dashboards') {
continue;
}

$menuItem = [
'moduleName' => $menu->menuname1,
'MenuId' => $menu->menuid,
'MenuDetailId' => $menu->menudetailid,
'MenuDetailSequence' => $menu->menusequence,
'perSlug' => $menu->menu_d_slug
];

if ($menu->is_submenu_available) {
$menuItem['menuName'] = $menu->submenudetailname1;
$menuItem['subMenuDetailId'] = $menu->submenudetailid;
$menuItem['isSubMenu'] = 1;
$menuItem['subMenuSequence'] = $menu->submenudetailid;
$menuItem['perSlug'] = $menu->menu_sub_slug;
} else {
$menuItem['menuName'] = $menu->menudetailname1;
$menuItem['subMenuDetailId'] = "";
$menuItem['perSlug'] = $menu->menu_d_slug;
}
$menus_arr[] = $menuItem;
}

// return $menus_arr;

$MenuList = collect($menus_arr)
->sortBy(function ($item) {
return [$item['MenuId'], $item['MenuDetailSequence'], $item['subMenuSequence'] ?? PHP_INT_MAX];
})->values()->all();

// $MenuList;

$dummyData = $this->generateDummyData(count($MenuList), 20);

// Merge the original data with the dummy data
// $MenuList = array_merge($MenuList, $dummyData);



if (request()->ajax()) {
return datatables()->of($MenuList)
->addColumn(
'form',
fn ($MenuList) =>
$MenuList['menuName'] .
'
<input type="hidden" id="MenuSlug" name="perSlug[]" value="' . $MenuList['perSlug'] . '">
<input type="hidden" id="ModuleName" name="MenuId[]" value="' . $MenuList['moduleName'] . '">
<input type="hidden" id="MenuName" name="MenuId[]" value="' . $MenuList['menuName'] . '">
<input type="hidden" id="MenuId" name="MenuId[]" value="' . $MenuList['MenuId'] . '">
<input type="hidden" id="MenuDetailId" name="MenuDetailId[]" value="' . $MenuList['MenuDetailId'] . '">
<input type="hidden" id="subMenuDetailId" name="subMenuDetailId[]" value="' . $MenuList['subMenuDetailId'] . '">
'
)
->addColumn(
'create',
fn ($MenuList) =>
'<input type="checkbox" name="create_chk_create[]" class="create-row-checkbox text-center form-check-input" value="' . $MenuList['perSlug'] . '-create" onclick="unselectAll(this,`create-row-checkbox`,`create-select-all-checkbox`)" />'
)
->addColumn(
'edit',
fn ($MenuList) =>
'<input type="checkbox" name="edit_chk_edit[]" class="edit-row-checkbox form-check-input text-center" value="' . $MenuList['perSlug'] . '-edit" onclick="unselectAll(this,`edit-row-checkbox`,`edit-select-all-checkbox`)" />'
)
->addColumn(
'view',
fn ($MenuList) =>
'<input type="checkbox" name="view_chk_view[]" class="view-row-checkbox form-check-input text-center" value="' . $MenuList['perSlug'] . '-view" onclick="unselectAll(this,`view-row-checkbox`,`view-select-all-checkbox`)" />'
)
->addColumn(
'delete',
fn ($MenuList) =>
'<input type="checkbox" name="delete_chk_delete[]" class="delete-row-checkbox form-check-input text-center" value="' . $MenuList['perSlug'] . '-delete" onclick="unselectAll(this,`delete-row-checkbox`,`delete-select-all-checkbox`)" />'
)
->rawColumns(['form', 'create', 'edit', 'view', 'delete'])
->addIndexColumn()
->make(true);
}


// return generateMenuSlug();
return view('pages/administration/permission/index', [
'roles' => Role::with('users:id,first_name,img')->get(),
'users' => User::get(['id', 'first_name', 'img']),
'userWithRoles' => User::with('roles')->get(),
]);
}


===============code peromance============
return $results = DB::table('tasks')
->join('employees', 'tasks.employee_id', '=', 'employees.id')
->where('tasks.report_manager_id', $empId)
->select(
'employees.username',
'employees.first_name',
'employees.last_name',
DB::raw('YEAR(tasks.eod_date) as year'),
DB::raw('MONTH(tasks.eod_date) as month'),
'tasks.eod_date',
'tasks.employee_id'
)
->groupBy('employees.username', DB::raw('YEAR(tasks.eod_date)'), DB::raw('MONTH(tasks.eod_date)'), 'tasks.eod_date', 'tasks.employee_id')
->orderBy('employees.username')
->orderBy('year')
->orderBy('month')
->get()
->groupBy('username'); // Group by username in the collection


return Task::join('employees', 'tasks.employee_id', '=', 'employees.id')
->where('tasks.report_manager_id', $empId)
->select(
'tasks.id',
'tasks.eod_date',
'tasks.employee_id',
'employees.username',
'employees.first_name',
'employees.last_name'
)
->groupBy('eod_date', 'employee_id')
->orderBy('employees.username')
->get()
->groupBy('username')
->map(function ($tasksByEmployee) {
return $tasksByEmployee->groupBy(function ($task) {
return \Carbon\Carbon::parse($task->eod_date)->format('Y-m'); // Group by year-month
});
});



return Task::join('employees', 'tasks.employee_id', '=', 'employees.id')
->where('tasks.report_manager_id', $empId)
->select(
'tasks.eod_date',
'tasks.employee_id',
'employees.username',
'employees.first_name',
'employees.last_name'
)
->groupBy('eod_date', 'employee_id')
->orderBy('employees.username') // Order by username for easier grouping
->get()
->groupBy('username'); // Group by username in the collection

return Task::where('report_manager_id', $empId)
->with('employee:id,first_name,last_name,username')
->select('eod_date', 'employee_id') // Specify columns to avoid errors in groupBy
->groupBy('eod_date', 'employee_id')
->get()
->groupBy(function ($task) {
return $task->employee->username; // Group by employee's username
});

return Task::where('report_manager_id', $empId)
->with('employee:id,first_name,last_name,username')
->select('eod_date', 'employee_id') // Specify columns to avoid errors in groupBy
->groupBy('eod_date', 'employee_id')
->get()
->groupBy('employee_id');

return Task::join('employees', 'tasks.employee_id', '=', 'employees.id')
->where('tasks.report_manager_id', $empId)
->select(
'tasks.id',
'tasks.eod_date',
'tasks.employee_id',
'employees.username',
'employees.first_name',
'employees.last_name'
)
->groupBy('eod_date', 'employee_id')
->orderBy('employees.username')
->get()
->groupBy('username')
->map(function ($tasksByEmployee) {
return $tasksByEmployee->groupBy(function ($task) {
return \Carbon\Carbon::parse($task->eod_date)->format('Y-m'); // Group by year-month
})->map(function ($tasksByMonth) {
return count($tasksByMonth);
});
});



return Task::join('employees', 'tasks.employee_id', '=', 'employees.id')
->where('tasks.report_manager_id', $empId)
->select(
'tasks.id',
'tasks.eod_date',
'tasks.employee_id',
'employees.username',
'employees.first_name',
'employees.last_name'
)
->groupBy('eod_date', 'employee_id')
->orderBy('employees.username')
->get()
->groupBy('username')
->map(function ($tasksByEmployee) {
return $tasksByEmployee->groupBy(function ($task) {
return \Carbon\Carbon::parse($task->eod_date)->format('Y-m'); // Group by year-month
})->map(function ($t) {
return count($t);
});
});

===============code peromance============

// $created->reportManager()->attach($request->report_manager_id, ['report_type' => 'eod_report']);
// $created->reportManager()->attach(['employee_id' => $created->id, 'report_manager_id' => $request->report_manager_id]);

// if ($request->has('report_manager_id')) {
// // $employee->reportManager()->sync([$request->report_manager_id]);
// $employee->reportManager()->sync([$request->report_manager_id => ['report_type' => 'eod_report']]);
// }

// return DB::table('user_logs')
// ->whereIn('user_id', function ($query) use ($employee) {
// $query->select('id')
// ->from('users')
// ->where('type', 'eod')
// ->whereIn('employee_id', $employee->reportingManager->pluck('id'));
// })->get();


===========================================
// $model = LeaveRequest::query()
// ->select(
// 'leave_requests.body',
// 'leave_requests.request_days',
// 'leave_requests.start_date',
// 'leave_requests.end_date',
// 'leave_requests.applied_employee_id',
// 'leave_requests.leave_type_id',
// 'lt.*',
// 'employee_leave_request.status',
// 'employee_leave_request.rejected_reason',
// 'employee_leave_request.approved_reason'
// )
// ->join('leave_types as lt', 'lt.id', '=', 'leave_requests.leave_type_id')
// ->join('employee_leave_request', 'employee_leave_request.leave_request_id', '=', 'leave_requests.id')
// ->where('employee_leave_request.employee_id', CurrentUser()->employee_id)
// ->paginate(15);
===========================================
