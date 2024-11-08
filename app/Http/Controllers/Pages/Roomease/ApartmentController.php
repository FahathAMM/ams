<?php

namespace App\Http\Controllers\Pages\Roomease;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Roomease\Apartment;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\Roomease\ApartmentRepo;
use App\Http\Requests\Apartment\StoreRequest;
use App\Http\Requests\Apartment\UpdateRequest;

class ApartmentController extends Controller
{
    protected $modelName = 'Apartment';
    protected $routeName = 'role.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Apartment $model, ApartmentRepo $repo)
    {
        $this->model = $model;
        $this->repo = $repo;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:administration-role-view')->only('index');
    }

    public function index(Request $request)
    {
        // return 'roomease/apartment';
        return view('pages/roomease/apartment/index', [
            'roles' =>   Role::with('users:id,first_name,img')->get(),
            'users' =>   User::get(['id', 'first_name', 'img']),
            'apartments' =>   $this->model->get(),
            'userWithRoles' => User::with('roles')->get(),
            'title' => $this->modelName,
        ]);
    }

    public function create(Request $request) {}

    public function store(StoreRequest $request)
    {
        try {
            $created =  $this->repo->createApartment($request);
            if ($created) {
                logActivity('Apartment Create', "Apartment ID " . $created->id, 'Create');
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
