<?php

namespace App\Http\Controllers\Pages\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Models\Branch\Branch;
use App\Models\Department\Department;
use App\Repositories\Organization\DepartmentRepo;

class DepartmentController extends Controller
{
    protected $modelName = 'Department';
    protected $routeName = 'department.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Department $model, DepartmentRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = $this->repo->getAccessPermission();
            $model = $this->model->with('branch:id,branch_name');

            return datatables()->of($model)->addIndexColumn()
                ->addColumn('action', function ($model) use ($permissions) {
                    return actionBtns(
                        $model->id,
                        'department.edit',
                        'organization/department',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.organization.department.index', [
            'title' => $this->modelName,
        ]);
    }

    public function create(Request $request)
    {
        $branch = Branch::get();
        return view('pages.organization.department.create', [
            'title' => $this->modelName,
            'branch' => $branch,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->repo->createDepartment($request);

            if ($created) {
                logActivity($this->modelName . ' Create',  $this->modelName . " ID " . $created->id, 'Create');
                return  $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            throw $th;
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function show(string $id)
    {
        return $id;
        return view('pages.organization.asset.show');
    }

    public function edit(Request $request, Department $department)
    {
        $branch = Branch::get();
        return view('pages.organization.department.edit', [
            'title' => $this->modelName,
            'department' => $department,
            'branch' => $branch,
        ]);
    }

    public function update(UpdateRequest $request, Department $department)
    {
        try {
            $updated = $this->repo->updateDepartment($request, $department);

            if ($updated) {
                logActivity($this->modelName . ' Update',  $this->modelName . " ID " . $department->id, 'Update');
                return  $this->response($this->modelName . ' updated successfully', ['data' => $department], true);
            }
        } catch (\Throwable $th) {
            throw $th;
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
