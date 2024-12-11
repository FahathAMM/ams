<?php

namespace App\Http\Controllers\Pages\Administration;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Administration\UserLoginActivityLog;

class UserController extends Controller
{
    protected $modelName = 'User';
    protected $routeName = 'user.index';
    protected $isDestroyingAllowed;
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->isDestroyingAllowed = true;

        $this->middleware('userpermission:administration-users-view')->only('index');
        $this->middleware('userpermission:administration-users-create')->only('create');
        $this->middleware('userpermission:administration-users-edit')->only('edit');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $permissions = [
                'isDelete' => true,
                'isEdit' => true,
                'isView' => false,
                'isPrint' => false
            ];

            $user = $this->model->query();

            // if ($request->has('role') && $request->role != -1) {
            //     $model->whereHas('roles', function ($q) use ($request) {
            //         $q->where('name', $request->role);
            //     });
            // }
            // $data = $model->with('roles')->get();

            return Datatables::of($user)->addIndexColumn()
                ->addColumn('action', function ($user) use ($permissions) {
                    return actionBtns(
                        $user->id,
                        'user.edit',
                        'user',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages/administration/user/index', [
            'roles' =>   Role::get(),
            'title' =>   $this->modelName,
            'headers' =>   $this->tableHeader(),
            'userWithRoles' => User::with('roles')->get(),
        ]);
    }

    public function loggedUserTracking(Request $request)
    {
        if ($request->ajax()) {
            $permissions = [
                'isDelete' =>  false,
                'isEdit' => false,
                'isView' => false,
                'isPrint' => false
            ];


            $loggedUserModel = UserLoginActivityLog::select([
                'user_login_activity_logs.id', // Explicitly mention the table
                'user_login_activity_logs.user_id',
                'action as login_status',
                'ip_address',
                'device',
                'os',
                'browser',
                'login_time',
                'status',
                DB::raw(
                    "CONCAT(
                        '<div class=\"d-flex align-items-center mb-3\">',
                        '<div class=\"flex-shrink-0 avatar-sm\">',
                        '<div class=\"avatar-title bg-light text-primary rounded-3\" style=\"font-size:30px\">',
                        CASE
                            WHEN device = 'Mobile' THEN '<i class=\"ri-smartphone-line\"></i>'
                            WHEN device = 'Tablet' THEN '<i class=\"ri-tablet-line\"></i>'
                            WHEN device = 'Desktop' THEN '<i class=\"ri-computer-line\"></i>'
                            ELSE '<i class=\"ri-question-line\"></i>'
                        END,
                        '</div>',
                        '</div>',
                        '<div class=\"flex-grow-1 ms-3\">',
                        '<h6>', device, '</h6>',
                        '<p class=\"text-muted mb-0\">',
                        'User ', ut.username, ' logged in successfully using <b>', IFNULL(browser, ''), '</b> on a running <b>', os,
                        '</b><b>', DATE_FORMAT(login_time, '%M %d at %l:%i %p'), '</b> from the IP address <b>', ip_address, '</b>',
                        '</p>',
                        '</div>',
                        '</div>'
                    ) AS formatted_message"
                )
            ])
                ->orderByDesc('login_time')
                ->join('users as ut', 'ut.id', '=', 'user_login_activity_logs.user_id');


            logActivity('Logged User History', 'Logged User History', 'View');

            return Datatables::of($loggedUserModel)->addIndexColumn()
                ->addColumn('action', function ($loggedUserModel) use ($permissions) {
                    return actionBtns(
                        $loggedUserModel->id,
                        'user.edit',
                        'user',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages/administration/user/logged-user-tracking', [
            'title' =>   'Logged User History',
        ]);
    }

    public function userActivity(Request $request)
    {
        if ($request->ajax()) {

            $permissions = [
                'isDelete' =>  false,
                'isEdit' => can('administration-users-edit'),
                'isView' => false,
                'isPrint' => false
            ];

            $userLogs = DB::table('user_logs')
                // ->get()
                ->where('log_action', '!=', 'View')
                ->orderBy('created_at', 'desc');


            logActivity('User Activity', 'User Activity', 'View');

            return Datatables::of($userLogs)->addIndexColumn()
                ->addColumn('action', function ($userLogs) use ($permissions) {
                    return actionBtns(
                        $userLogs->id,
                        'user.edit',
                        'user',
                        '',
                        $permissions
                    );
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages/administration/user/user-activity', [
            'title' =>   'User Activity',
        ]);
    }

    public function create()
    {
        return view('pages/administration/user/create', [
            'title' =>   'Create User',
            'roles' =>   Role::get(),
            'userWithRoles' => User::with('roles')->get()
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $created = $this->model->create($request->validated());

            if ($created) {
                if ($request->hasFile('img')) {
                    $path =  $request->file('img')->store('profile', 'public');
                    $created->img = $path;
                    $created->save();
                }
                return  $this->response($this->modelName . ' created successfully', ['data' => $created], true);
            }
        } catch (\Throwable $th) {
            throw $th;
            return  $this->response($th->getMessage(), null, false);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        try {
            // return $user;
            // return $user;
            // Load the user with roles eagerly loaded
            $userWithRoles = User::with('roles')->get();

            // Get attribute statistics
            $attributeStats = $this->getAttributeStats($user);

            $user->load('roles', 'employee'); // Load roles and employee relations

            // $user->employee->img ?? $user->img;

            return view('pages/administration/user/edit', [
                'roles' =>   Role::get(),
                'user' => $user,
                'percentageFilled' => $attributeStats['percentageFilled'],
                'title' =>   $this->modelName,
            ]);
        } catch (\Throwable $th) {
            // Handle any errors here if needed
            // Log or return an error response
            // throw $th; // Uncomment this line if you want to throw the exception for debugging
        }
    }

    public function update(UpdateRequest $request, User $user)
    {
        try {
            $data = $request->validated();

            // Check if the password is provided and hash it if it is
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                // If the password is not provided, remove it from the data array
                unset($data['password']);
            }

            $userUpdated = $user->update($data);
            if ($userUpdated) {
                if ($request->hasFile('img')) {
                    $path = $request->file('img')->store('profile', 'public');
                    $user->img = $path;
                    $user->save();

                    $user->employee->img = $path;
                    $user->employee->save();
                }
                return $this->response($this->modelName . ' updated successfully', ['data' => $user], true);
            }
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), null, false);
        }
    }

    public function destroy(string $id) {}

    private function tableHeader(): array
    {
        return [
            // ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#'],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false]
        ];
    }

    private function getAttributeStats(User $user)
    {
        // Convert user to array for easier manipulation
        $userArray = json_decode(json_encode($user), true);

        // Initialize counters
        // $totalAttributes = count($userArray) - 6;
        $totalAttributes = count($userArray);
        $filledAttributes = 0;

        // Count filled attributes
        foreach ($userArray as $key => $value) {
            if (!empty($value)) {
                $filledAttributes++;
            }
        }

        // Calculate percentage of filled attributes
        $percentageFilled = ($totalAttributes > 0) ? ($filledAttributes / $totalAttributes) * 100 : 0;

        // Return attribute statistics
        return [
            'totalAttributes' => $totalAttributes,
            'filledAttributes' => $filledAttributes,
            'percentageFilled' => round($percentageFilled, 0),
        ];
    }
}
