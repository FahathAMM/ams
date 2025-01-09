<?php

namespace App\Http\Controllers\Pages\Development;

use Exception;
use Faker\Factory;
use App\Models\Task\Task;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DevController extends Controller
{
    protected $modelName = 'Dashboard';
    protected $routeName = 'dashboard.index';
    protected $isDestroyingAllowed;

    protected $model;
    protected $repo;

    public function __construct()
    {
        $this->isDestroyingAllowed = true;
    }

    public  function getRoutes(Request $request)
    {
        try {
            $routes = Route::getRoutes()->get();
            return view('development.routes', compact('routes'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function Permissions(Request $request)
    {
        if ($request->ajax()) {
            $permissions = [
                'isDelete' =>  false,
                'isEdit' => false,
                'isView' => false,
                'isPrint' => false
            ];

            // logActivity('Logged User History', 'Logged User History', 'View');

            $permissionList = DB::table('permissions');

            return Datatables::of($permissionList)->addIndexColumn()
                ->addColumn('action', function ($permissionList) use ($permissions) {
                    return actionBtns(
                        $permissionList->id,
                        'user.edit',
                        'user',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages/development/permission', [
            'title' =>   'permission Lis',
        ]);
    }
}
