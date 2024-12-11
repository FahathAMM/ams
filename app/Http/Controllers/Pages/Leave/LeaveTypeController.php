<?php

namespace App\Http\Controllers\Pages\Leave;

use Illuminate\Http\Request;
use App\Models\Leave\LeaveType;
use App\Http\Controllers\Controller;
use App\Repositories\Leave\LeaveTypeRepo;
use App\Http\Requests\Leavetype\StoreRequest;
use App\Http\Requests\Leavetype\UpdateRequest;

class LeaveTypeController extends Controller
{
    protected $modelName = 'Leave Type';
    protected $routeName = 'leavetype.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(LeaveType $model, LeaveTypeRepo $repo)
    {
        $this->model = $model;
        $this->repo = $repo;
        $this->isDestroyingAllowed = true;

        // $this->middleware('userpermission:administration-role-view')->only('index');
    }

    public function index(Request $request)
    {
        return view('pages/leave/leavetype/index', [
            'leaveTypes' =>   $this->model->get(),
            'title' => $this->modelName,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->repo->createLeaveType($request);
            if ($created) {
                logActivity($this->modelName . ' Create', "Leave Type ID " . $created->id, 'Create');
                return $this->response($this->modelName . ' created successfully', ['data' => $created], true);
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
        //
    }

    public function update(UpdateRequest $request, LeaveType $leaveType)
    {
        try {
            $updated = $this->repo->updateLeaveType($request, $leaveType);

            if ($updated) {
                logActivity($this->modelName . ' Create', "Leave Type ID " . $leaveType->id, 'Update');
                return  $this->response($this->modelName . ' update successfully', ['data' => $updated], true);
            }
        } catch (\Throwable $th) {
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(LeaveType $leaveType)
    {
        try {
            $deleted = $leaveType->delete();
            if ($deleted) {
                logActivity($this->modelName . ' Create', "Leave Type ID " . $leaveType->id, 'Delete');
                return $this->response($this->modelName . ' successfully deleted.', $deleted, true);
            } else {
                return $this->response($this->modelName . ' cannot deleted.', null, false);
            }
        } catch (\Throwable $th) {
            return $this->response($th, null, false);
        }
    }
}
