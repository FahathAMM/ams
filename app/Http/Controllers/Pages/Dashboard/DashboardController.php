<?php

namespace App\Http\Controllers\Pages\Dashboard;

use Exception;
use Faker\Factory;
use App\Models\Task\Task;
use App\Models\Leave\LeaveType;
use App\Models\Customer\Customer;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
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

    public function index()
    {
        $userLogs = $this->getUserActivites();
        return view('pages/dashboard/index', [
            'title' => $this->modelName,
            'userLogs' => $userLogs,
            'eodChart' => [],

        ]);
    }

    public function GetKPIs()
    {
        $counts = DB::table('employees')
            ->selectRaw("'Total Employees' as title, count(*) as value, 'text-info' as percentageClass, 'fas fa-users' as icon, 'bg-info-subtle' as iconBg, 'text-info' as iconColor, '' as percentage, '' as valueSuffix, '#' as linkUrl")
            ->unionAll(
                DB::table('employee_report')
                    ->selectRaw("'Total Assigned Employees' as title, count(*) as value, '' as percentageClass, 'fas fa-user-friends' as icon, 'bg-success-subtle' as iconBg, 'text-success' as iconColor, '' as percentage, '' as valueSuffix, '#' as linkUrl")
                    ->when(isset(currentUser()->employee->id), function ($query) {
                        $query->where('report_manager_id', currentUser()->employee->id);
                    })
            )
            ->unionAll(
                DB::table('customers')
                    ->selectRaw("'Total Customers' as title, count(*) as value, '' as percentageClass, 'fas fa-user-tie' as icon, 'bg-success-subtle' as iconBg, 'text-success' as iconColor, '' as percentage, '' as valueSuffix, '#' as linkUrl")
            )
            ->unionAll(
                DB::table('customers')
                    ->selectRaw("'Total Customers' as title, count(*) as value, '' as percentageClass, 'fas fa-user-tie' as icon, 'bg-success-subtle' as iconBg, 'text-success' as iconColor, '' as percentage, '' as valueSuffix, '#' as linkUrl")
            )
            ->get();

        $dashboardData = $counts->map(function ($item) {
            return [
                'title' => $item->title,
                'percentage' => $item->percentage,
                'percentageClass' => $item->percentageClass,
                'icon' => $item->icon,
                'iconBg' => $item->iconBg,
                'iconColor' => $item->iconColor,
                'value' => $item->value,
                'valueSuffix' => $item->valueSuffix,
                'link' => $item->title,
                'linkUrl' => $item->linkUrl,
            ];
        })->toArray();

        return response()->json($dashboardData);
    }

    public function getEodChartByEmployee()
    {
        if (!isset(currentUser()->employee->id)) {
            return response()->json(['status' => false]);
        }

        $empId = currentUser()->employee->id;
        $eodChart = Task::join('employees', 'tasks.employee_id', '=', 'employees.id')
            ->where('tasks.report_manager_id', $empId)
            ->select(
                'tasks.id',
                'tasks.eod_date',
                'tasks.employee_id',
                'employees.username',
                'employees.first_name',
                'employees.last_name'
            )
            ->groupBy('eod_date', 'employee_id')
            ->orderBy('eod_date', 'asc')
            ->get()
            ->groupBy('username')
            ->map(function ($tasksByEmployee) {
                return $tasksByEmployee->groupBy(function ($task) {
                    return \Carbon\Carbon::parse($task->eod_date)->format('Y-m'); // Group by year-month
                })->map(function ($t) {
                    return count($t);
                });
            });

        $eodChart = $eodChart->toArray();

        $series = [];

        $months = array_unique(array_keys(array_merge_recursive(...array_values($eodChart))));

        // Sort dates
        usort($months, function ($a, $b) {
            return strtotime($a . '-01') - strtotime($b . '-01');
        });

        foreach ($eodChart as $name => $monthlyData) {
            $seriesData = [];

            foreach ($months as $month) {
                $seriesData[] = $monthlyData[$month] ?? 0;
            }
            $series[] = [
                'name' => $name,
                'data' => $seriesData,
            ];
        }
        return response()->json(['series' => $series, 'months' => $months, 'status' => true]);
    }

    private function getUserActivites()
    {
        $baseUrl = config('app.url') . '/public/storage/';
        $defaultImg = asset('storage/demo/dm-profile.jpg');

        $logs = DB::table('user_logs')
            ->where('log_action', '!=', 'View')
            ->orderBy('created_at', 'desc')
            ->take(100)
            ->join('users as u', 'u.id', '=', 'user_logs.user_id')
            ->get([
                'user_logs.user_id',
                'user_logs.user_name',
                'user_logs.form_name',
                'user_logs.form_record_id',
                'user_logs.log_action',
                'user_logs.created_at',
                'u.img as img1',
                DB::raw("
                        CASE
                            WHEN u.img IS NULL OR u.img = '' THEN '$defaultImg'
                            ELSE CONCAT('$baseUrl', u.img)
                        END AS img
                    ")
            ]);

        return $logs;
    }

    public function fakeData()
    {
        $faker = Factory::create();

        // Fetch all user and customer IDs from the respective tables
        $employeeIds = Employee::pluck('id')->toArray();  // Assuming 'id' is the primary key in the 'users' table
        $customerIds = Customer::pluck('id')->toArray();  // Assuming 'id' is the primary key in the 'customers' table

        if (empty($employeeIds) || empty($customerIds)) {
            throw new Exception('Employee or Customer ID array is empty. Ensure there are records in the employees and customers tables.');
        }

        for ($i = 1; $i <= 5000; $i++) {
            DB::table('tasks')->insert([
                'employee_id' =>  $faker->randomElement($employeeIds),
                'report_manager_id' =>  $faker->randomElement($employeeIds),
                'customer_id' => $faker->randomElement($customerIds),
                'eod_date' => $faker->date('Y-m-d'),
                'subject' => $faker->sentence(3),
                'task_code' => 'TASK' . $faker->unique()->numberBetween(10, 6000),
                'task_description' => $faker->sentence(6),

                // Generate a random duration in the format of 'hours:minutes'
                'duration' => sprintf('%02d:%02d', $faker->numberBetween(0, 23), $faker->numberBetween(0, 59)),

                'description' => $faker->paragraph,

                // Set the status to one of 'WIP', 'Pending', or 'Complete'
                'status' => $faker->randomElement(['wip', 'pending', 'completed']),
            ]);
        }
    }

    public function tips()
    {
        // return $this->GetKPIs();

        // return fetchCurrentEmployeeWithAssignedReportingEmployees();
        // return currentUser()->getPermissionsViaRoles();

        // return customEncrypt('Fahath@123');
        // return request()->ip();

        // return  $hh =  LeaveType::pluck('id')->toArray();
        // return   $jj = json_encode(implode(',', LeaveType::pluck('id')->toArray()));
        // $jj = implode(',', LeaveType::pluck('id')->toArray());

        // $jj = json_encode(
        //     LeaveType::pluck('id')->map(fn($id) => (string)$id)->toArray()
        // );

        // return  explode(',', $jj);
        // Fetch all leave types as a collection
        // $leaveTypes = LeaveType::all();

        // // Prepare leave balance data in bulk
        // $leaveBalances = $leaveTypes->map(function ($type) {
        //     return [
        //         'user_id' => 1,
        //         'leave_type_id' => $type->id,
        //         'remaining_days' => $type->number_of_days,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // })->toArray();

        // // Insert all leave balances at once
        // DB::table('leave_balances')->insert($leaveBalances);



        // Employee::where('emp_number', 'EMP1019d')->delete();
        // Employee::where('emp_number', 'EMP1019d')->delete();
        // return Employee::create(
        //     [
        //         'first_name' => 'Suranjith',
        //         'last_name' => '',
        //         'username' => 'Suranjithd',
        //         'password' => 'Suranjith@123',
        //         'emp_number' => 'EMP1019d',
        //         'designation' => 'Customer Support',
        //         'phone_number' => '123-456-7809',
        //         'email' => 'suranjdith@example.com',
        //         'branch_id' => 3,
        //         'department_id' => 'Support',
        //         'joining_date' => '2024-04-05',
        //         'country' => 'Sri Lanka',
        //         'img' => null,
        //         'cover_img' => 'cover_img_path_18',
        //         'leave_types' => '',
        //         'description' => 'Dedicated to providing excellent customer support.',
        //     ],
        // );

        // return  $notAssignedEmployees = Employee::whereNotIn('id', function ($query) {
        //     $query->select('employee_id')
        //         ->from('employee_report');
        // })
        //     ->toSql();
        // ->get(['id as value', 'username as text', DB::raw('false as selected')]);
    }
}
