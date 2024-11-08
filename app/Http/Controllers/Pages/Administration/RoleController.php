<?php

namespace App\Http\Controllers\Pages\Administration;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Models\Menu\Menu;
use App\Repositories\Administration\RoleRepo;

class RoleController extends Controller
{
    protected $modelName = 'Role';
    protected $routeName = 'role.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Role $model, RoleRepo $repo)
    {
        $this->model = $model;
        $this->repo = $repo;
        $this->isDestroyingAllowed = true;

        $this->middleware('userpermission:administration-role-view')->only('index');
    }

    public function index(Request $request)
    {
        return view('pages/administration/role/index', [
            'roles' =>   Role::with('users:id,first_name,img')->get(),
            'users' =>   User::get(['id', 'first_name', 'img']),
            'userWithRoles' => User::with('roles')->get(),
            'title' => $this->modelName,
        ]);
    }

    public function create(Request $request) {}

    public function store(StoreRequest $request)
    {
        try {
            $created =  $this->repo->createRole($request);
            if ($created) {
                logActivity('Role Create', "Role ID " . $created->id, 'Create');
                return  $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        return  $this->response($this->modelName . ' created successfully', ['data' => $id], true);
    }

    public function update(UpdateRequest $request, Role $role)
    {
        try {
            $update = $role->update(['name' => $request->name]);

            if ($update) {
                logActivity('Role Update', "Role ID " . $role->id, 'Update');
                if ($request->has('assignedTo')) {
                    $role->users()->detach(); // Detach all users from the role
                    foreach ($request->assignedTo as $key => $userId) {
                        $user = User::find($userId);
                        $user->assignRole($request->name);
                    }
                }
                return  $this->response($this->modelName . ' update successfully', ['data' => $update], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(Role $role)
    {
        try {
            // Project Manager
            $deleted = $role->delete();
            if ($deleted) {

                logActivity('Role Delete', "Role ID " . $role->id, 'Delete');

                return $this->response($this->modelName . ' successfully deleted.', $deleted, true);
            } else {
                return $this->response($this->modelName . ' cannot deleted.', null, false);
            }
        } catch (\Throwable $th) {
            return $this->response($th, null, false);
        }
    }
}
