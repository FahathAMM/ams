<?php

namespace App\Http\Controllers\Pages\Organization;

use App\Models\Asset\Asset;
use Illuminate\Http\Request;
use App\Models\Asset\Attribute;
use App\Models\Employee\Employee;
use App\Models\asset\AssetCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreRequest;
use App\Http\Requests\Asset\UpdateRequest;
use App\Repositories\Organization\AssetRepo;

class AssetController extends Controller
{
    protected $modelName = 'Asset';
    protected $routeName = 'asset.index';
    protected $isDestroyingAllowed;
    protected $model;
    protected $repo;

    public function __construct(Asset $model, AssetRepo $repo)
    {
        $this->repo = $repo;
        $this->model = $model;
        $this->isDestroyingAllowed = true;
        $this->middleware('userpermission:assets-asset-view')->only('index');
        $this->middleware('userpermission:assets-asset-create')->only('create');
        $this->middleware('userpermission:assets-asset-edit')->only('edit');
    }

    public function index(Request $request)
    {
        // $asset = $this->repo->query();
        // return  $asset = $asset->with('category', 'employee')->get();

        if ($request->ajax()) {
            $permissions = $this->repo->getAccessPermission();
            $asset = $this->model->query();
            // $asset = $asset->with('employee:id as empid,first_name,last_name,username');
            $asset = $asset->select('assets.id', 'serial_number', 'issue_date', 'assets.is_active', 'assets.name', 'employee_id', 'category_id')
                ->with(['category:id,name', 'employee:id,first_name,last_name']);

            return datatables()->of($asset)->addIndexColumn()
                ->addColumn('action', function ($asset) use ($permissions) {
                    return actionBtns(
                        $asset->id,
                        'asset.edit',
                        'assets/asset',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.organization.asset.index', [
            'title' =>   $this->modelName,
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.organization.asset.create', [
            'assetCategories' => AssetCategory::get(['id', 'name']),
            'employees' => Employee::get(['id', 'first_name', 'last_name']),
            'attributes' => Attribute::get(['id', 'name']),
            'title' =>   $this->modelName,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->repo->createAsset($request);

            if ($created) {
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

    public function edit(string $id)
    {
        // return $this->repo->with('attributes', 'category', 'employee')->find($id);
        return view('pages.organization.asset.edit', [
            'assetCategories' => AssetCategory::get(['id', 'name']),
            'employees' => Employee::get(['id', 'first_name', 'last_name']),
            'title' =>   $this->modelName,
            'attributes' => Attribute::get(['id', 'name']),
            'asset' => $this->repo->with('attributes', 'category', 'employee')->find($id)
        ]);
    }

    public function update(UpdateRequest $request, Asset $asset)
    {
        try {
            $updated = $this->repo->updateAsset($request, $asset);

            if ($updated) {
                return  $this->response($this->modelName . ' updated successfully', ['data' => $asset], true);
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
