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
                logActivity($this->modelName . ' Create', $this->modelName . " ID " . $created->id, 'Create');
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
        return $this->response($this->modelName . ' created successfully', ['data' => $id], true);
    }

    public function update(UpdateRequest $request, Apartment $apartment)
    {
        try {
            $updated = $this->repo->updateApartment($request, $apartment);

            if ($updated) {
                logActivity('Apartment Create', "Apartment ID " . $apartment->id, 'Update');
                return  $this->response($this->modelName . ' update successfully', ['data' => $updated], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(Apartment $apartment)
    {
        try {
            $deleted = $apartment->delete();
            if ($deleted) {
                logActivity('Apartment Delete', "Apartment ID " . $apartment->id, 'Delete');
                return $this->response($this->modelName . ' successfully deleted.', $deleted, true);
            } else {
                return $this->response($this->modelName . ' cannot deleted.', null, false);
            }
        } catch (\Throwable $th) {
            return $this->response($th, null, false);
        }
    }
}
