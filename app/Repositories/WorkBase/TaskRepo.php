<?php

namespace App\Repositories\WorkBase;

use App\Models\User;
use App\Models\Task\Task;
use App\Repositories\BaseRepository;

class TaskRepo extends BaseRepository
{
    protected $model;

    public function __construct(Task $model)
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

    public function createTask($request)
    {
        $task_ids = $request->task_id;
        $customer_ids = $request->customer_id;
        $task_description = $request->task_description;
        $task_durations = $request->task_duration;
        $task_status = $request->task_status;
        $description = $request->description;
        $subject = $request->subject;
        $date = $request->date;
        $repoting_manager_id = $request->repoting_manager_id;
        $employee_id = currentUser()->employee->id;

        try {
            // return  $request->task_id && count($task_ids) > 0;
            if ($subject && $request->task_id && count($task_ids) > 0) {
                foreach ($task_ids as $key => $item) {
                    // return $task_durations[$key];
                    $created = $this->model->create([
                        'employee_id' => $employee_id,
                        'report_manager_id' => $repoting_manager_id,
                        'customer_id' => $customer_ids[$key],
                        'eod_date' => $date,
                        'subject' => $subject,
                        'task_code' => $task_ids[$key],
                        'task_description' => $task_description[$key],
                        'duration' => $task_durations[$key],
                        'description' => $description,
                        'status' => $task_status[$key],
                    ]);
                }
                return true;
            }
            return false;
        } catch (\Exception $th) {
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
