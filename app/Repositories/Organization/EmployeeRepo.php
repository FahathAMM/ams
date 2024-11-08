<?php

namespace App\Repositories\Organization;

use App\Models\User;
use App\Models\Employee\Employee;
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
            $created = $this->model->create($request->validated());
            if ($created) {
                $created->reportManager()->attach($request->report_manager_id);
                // $created->reportManager()->attach(['employee_id' => $created->id, 'report_manager_id' => $request->report_manager_id]);
                if ($request->hasFile('img')) {
                    $this->model->imageUpload('/profile', $created, $request->file('img'), 'img');
                }
                $this->createUserByEmployee($request, $created->id);
                return $created;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        // } catch (\Exception $e) {
        //     return $e->getMessage();
        // }
        return false;
    }

    public function updateEmployee($request, $employee)
    {
        try {
            $data = $request->validated();

            // Check if the password is provided and hash it if it is
            if (!empty($data['password'])) {
                $data['password'] = customEncrypt($data['password']); // bcrypt($data['password']);
            } else {
                // If the password is not provided, remove it from the data array
                unset($data['password']);
            }

            $employeeUpdated = $employee->update($data);
            if ($employeeUpdated) {

                if ($request->has('report_manager_id')) {
                    $employee->reportManager()->sync([$request->report_manager_id]);
                }

                if ($request->hasFile('img')) {
                    $path = $request->file('img')->store('profile', 'public');
                    $employee->img = $path;
                    $employee->save();
                }
                return $employeeUpdated;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function createUserByEmployee($request, $empId)
    {
        try {
            $data = $request->validated();
            // dd($data);
            $data['employee_id'] = $empId;
            User::create($data);
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    public function findEmployeeById($id)
    {
        try {
            $emp = $this->model->with(['assets' => ['category', 'attributes'], 'reportingManager:id,first_name,last_name,img'])->find($id);
            return $emp;
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
