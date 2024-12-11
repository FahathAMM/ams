<?php

namespace App\Repositories\Organization;

use App\Models\User;
use App\Models\Leave\LeaveType;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;

class EmployeeRepo extends BaseRepository
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function __call($method, $parameters)
    {
        // Forward calls to the model instance
        $isExisit = $this->model->$method(...$parameters);

        if ($isExisit) {
            return $isExisit;
        }

        throw new \BadMethodCallException("Method {$method} does not exist on the model.");
    }

    public function createEmployee($request)
    {
        try {
            $data = $request->validated();
            $data['leave_types'] =  LeaveType::pluck('id')->toArray();

            $created = $this->model->create($data);
            if ($created) {

                if ($request->hasFile('img')) {
                    $this->model->imageUpload('/profile', $created, $request->file('img'), 'img');
                }
                $this->createUserByEmployee($request, $created->id);
                // sleep(4);
                $this->createLeaveBalance($created);
                return $created;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        return false;
    }

    // private function createLeaveBalance($created)
    // {
    //     $leaveTypes = LeaveType::all();

    //     $leaveBalances = $leaveTypes->map(function ($type) use ($created) {
    //         return [
    //             'employee_id' => $created->id,
    //             'leave_type_id' => $type->id,
    //             'remaining_days' => $type->number_of_days,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     })->toArray();

    //     DB::table('leave_balances')->insert($leaveBalances);
    // }

    private function createLeaveBalance($employeeId)
    {
        if ($employeeId) {
            $leaveTypes = LeaveType::all();
            foreach ($leaveTypes as $type) {
                DB::table('leave_balances')->updateOrInsert(
                    [
                        'employee_id' => $employeeId,
                        'leave_type_id' => $type->id,
                    ],
                    [
                        'remaining_days' => $type->number_of_days,
                        'updated_at' => now(),
                        'created_at' => now(), // Only used on insert; ignored on update
                    ]
                );
            }
        }
    }


    public function updateEmployee($request, $employee)
    {
        try {
            $data = $request->validated();

            if (!empty($data['password'])) {
                $data['password'] =  $data['password']; // bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $employeeUpdated = $employee->update($data);
            if ($employeeUpdated) {
                // DB::table('leave_balances')->where('employee_id', $employee->id)->whereNotIn('leave_type_id', $request->leave_types)->delete();
                if ($request->hasFile('img')) {
                    $path = $request->file('img')->store('profile', 'public');
                    $employee->img = $path;
                    $employee->save();
                    User::whereEmployeeId($employee->id)->update(['img' => $path]);
                }

                $this->createLeaveBalance($employee->id);

                return $employeeUpdated;
            }
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function createUserByEmployee($request, $empId)
    {
        try {
            $data = $request->validated();
            $data['employee_id'] = $empId;
            User::create($data);
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    public function findEmployeeById($id)
    {
        try {
            $emp = $this->model->with(['assets' => ['category', 'attributes'], 'reportingManager:id,first_name,last_name,img', 'department'])->find($id);
            return $emp;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getLeaveStatusEmployeeById($id)
    {
        try {
            return DB::table('leave_balances')->whereEmployeeId($id)->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function assignedEmployeeEodLogs($employee)
    {
        try {
            $baseUrl = config('app.url') . '/public/storage/';

            return DB::table('user_logs')
                ->join('users', 'user_logs.user_id', '=', 'users.id')
                ->join('employees', 'users.employee_id', '=', 'employees.id')
                ->where('user_logs.type', 'eod')
                ->whereIn('users.employee_id', $employee->reportingManager->pluck('id'))
                ->select('user_logs.*', DB::raw("CONCAT('$baseUrl', employees.img) AS img_url"))
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAccessPermission(): array
    {
        return [
            'isView' => true,
            'isEdit' => false,
            'isDelete' =>  false,
            'isPrint' => false
        ];
    }
}
