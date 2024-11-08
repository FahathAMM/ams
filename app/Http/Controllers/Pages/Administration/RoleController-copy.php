<?php

namespace App\Http\Controllers\Pages\Administration;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;

class RoleController extends Controller
{
    protected $modelName = 'Role';
    protected $routeName = 'role.index';
    protected $isDestroyingAllowed;
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
        $this->isDestroyingAllowed = true;
    }

    public function index(Request $request)
    {
        // return  $data = User::with('roles')->get();
        // $model = User::query();

        // if ($request->has('role') && $request->role != -1) {
        //     $model->whereHas('roles', function ($q) use ($request) {
        //         $q->where('name', $request->role);
        //     });
        // }

        // $result = $model->with('roles')->get();


        if ($request->ajax()) {

            $model = User::query();
            if ($request->has('role') && $request->role != -1) {
                $model->whereHas('roles', function ($q) use ($request) {
                    $q->where('name', $request->role);
                });
            }

            $data = $model->with('roles')->get();

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages/administration/role/index', [
            'roles' =>   Role::with('users:id,first_name,img')->get(),
            'users' =>   User::get(['id', 'first_name', 'img']),
            'userWithRoles' => User::with('roles')->get(),
        ]);
    }

    public function create(Request $request)
    {
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->model->create(['name' => $request->name]);

            if ($created) {
                if ($request->has('assignedTo')) {
                    foreach ($request->assignedTo as $key => $userId) {
                        $user = User::find($userId);
                        $user->assignRole($request->name);
                    }
                }
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

    public function destroy(string $id)
    {
        //
    }
}
