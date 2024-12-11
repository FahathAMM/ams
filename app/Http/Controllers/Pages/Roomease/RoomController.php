<?php

namespace App\Http\Controllers\Pages\Roomease;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Roomease\Room;
use App\Models\Roomease\Apartment;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\Roomease\ApartmentRepo;
use App\Http\Requests\Room\StoreRequest;
use App\Http\Requests\Room\UpdateRequest;
use App\Repositories\Roomease\RoomRepo;
use AppendIterator;

class RoomController extends Controller
{
    protected $modelName = 'Room';
    protected $routeName = 'role.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Room $model, RoomRepo $repo)
    {
        $this->model = $model;
        $this->repo = $repo;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:administration-role-view')->only('index');
    }

    public function index(Request $request)
    {
        // return 'roomease/apartment';
        return view('pages/roomease/room/index', [
            'apartments' =>  Apartment::get(),
            'rooms' =>   $this->model->latest()->get(),
            'userWithRoles' => User::with('roles')->get(),
            'title' => $this->modelName,
        ]);
    }

    public function create(Request $request) {}

    public function store(StoreRequest $request)
    {
        try {
            // return $request;
            $created =  $this->repo->createRoom($request);
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

    public function update(UpdateRequest $request, Room $room)
    {
        try {
            $updated = $this->repo->updateRoom($request, $room);

            if ($updated) {
                logActivity($this->modelName . ' Create', $this->modelName . " ID " . $room->id, 'Update');
                return  $this->response($this->modelName . ' update successfully', ['data' => $updated], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(Room $room)
    {
        try {
            $deleted = $room->delete();
            if ($deleted) {
                logActivity($this->modelName . ' Create', $this->modelName . " ID " . $room->id, 'Delete');
                return $this->response($this->modelName . ' successfully deleted.', $deleted, true);
            } else {
                return $this->response($this->modelName . ' cannot deleted.', null, false);
            }
        } catch (\Throwable $th) {
            return $this->response($th, null, false);
        }
    }
}
