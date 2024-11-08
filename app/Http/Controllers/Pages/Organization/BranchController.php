<?php

namespace App\Http\Controllers\Pages\Organization;

use App\Models\Asset\Asset;
use Illuminate\Http\Request;
use App\Models\Asset\Attribute;
use App\Models\Employee\Employee;
use App\Models\asset\AssetCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\StoreRequest;
use App\Http\Requests\Branch\UpdateRequest;
use App\Models\Branch\Branch;
use App\Repositories\Organization\BranchRepo;

class BranchController extends Controller
{
    protected $modelName = 'Branch';
    protected $routeName = 'branch.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Branch $model, BranchRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;
    }

    public function index(Request $request)
    {
        // $branchs = $this->repo->query();
        //    $branchs = $branchs->get();

        if ($request->ajax()) {
            $permissions = $this->repo->getAccessPermission();
            $branchs = $this->model->query();

            return datatables()->of($branchs)->addIndexColumn()
                ->addColumn('action', function ($branchs) use ($permissions) {
                    return actionBtns(
                        $branchs->id,
                        'branch.edit',
                        'organization/branch',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.organization.branch.index', [
            'title' =>   $this->modelName,
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.organization.branch.create', [
            'title' => $this->modelName,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->repo->createBranch($request);

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

    public function edit(Request $request, Branch $branch)
    {
        return view('pages.organization.branch.edit', [
            'title' => $this->modelName,
            'branch' => $branch,
        ]);
    }

    public function update(UpdateRequest $request, Branch $branch)
    {
        try {
            $updated = $this->repo->updateBranch($request, $branch);

            if ($updated) {
                logActivity($this->modelName . ' Update',  $this->modelName . " ID " . $branch->id, 'Update');
                return  $this->response($this->modelName . ' updated successfully', ['data' => $branch], true);
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
