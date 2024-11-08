<?php

namespace App\Http\Controllers\Pages\Administration;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Repositories\Administration\PermissionRepo;

class PermissionController extends Controller
{
    protected $modelName = 'Permission';
    protected $routeName = 'permission.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Permission $model, PermissionRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;
        $this->middleware('userpermission:administration-permission-view')->only('index');
    }

    public function index(Request $request)
    {
        $roleId = $request->roleId ?? 1;
        $permissionListByRole = $this->repo->getPermissionListByRole($roleId);
        $menusArr = $this->repo->getMenuList();

        gettype($menusArr);

        $MenuList = collect($menusArr)
            ->sortBy(['MenuId', 'MenuDetailSequence', 'subMenuSequence'])
            ->values()
            ->all();

        if (request()->ajax()) {
            return datatables()->of($MenuList)
                ->addColumn('form', fn($MenuList) => $this->repo->generateFormHiddenFields($MenuList))
                ->addColumn('create', fn($MenuList) => $this->repo->generateCheckbox('create', $MenuList['perSlug'], $permissionListByRole))
                ->addColumn('edit', fn($MenuList) => $this->repo->generateCheckbox('edit', $MenuList['perSlug'], $permissionListByRole))
                ->addColumn('view', fn($MenuList) => $this->repo->generateCheckbox('view', $MenuList['perSlug'], $permissionListByRole))
                ->addColumn('delete', fn($MenuList) => $this->repo->generateCheckbox('delete', $MenuList['perSlug'], $permissionListByRole))
                ->rawColumns(['form', 'create', 'edit', 'view', 'delete'])
                ->addIndexColumn()
                ->make(true);
        }

        logActivity('Permission Master', 'Permission Master', 'View');
        return view('pages/administration/permission/index', [
            'roles' => Role::with('users:id,first_name,img')->get(),
            'users' => User::get(['id', 'first_name', 'img']),
            'userWithRoles' => User::with('roles')->get(),
            'title' => $this->modelName,
        ]);
    }

    public function update(Request $request)
    {
        try {
            $permissionList = $request->rowData;
            $roleId = $request->roleId;

            // return [
            //     $permissionList,
            //     $roleId
            // ];

            logActivity('Permission Update', 'Role ID ' . $roleId, 'Update');
            $role = Role::find($roleId);
            $allPerList = array_flip(Permission::pluck('name', 'id')->toArray());
            $role->revokePermissionTo($role->permissions);
            foreach ($permissionList as $per) {
                foreach (['createValue', 'editValue', 'viewValue', 'deleteValue'] as $action) {
                    $perId = $allPerList[$per[$action]] ?? false;
                    if ($perId) {
                        $role->givePermissionTo($perId);
                    }
                }
            }
            return  $this->response($this->modelName . ' updated successfully', ['data' => []], true);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
