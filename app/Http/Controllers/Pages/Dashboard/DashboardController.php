<?php

namespace App\Http\Controllers\Pages\Dashboard;

use Exception;
use Faker\Factory;
use App\Models\User;
use App\Models\Customer\Customer;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use NotificationChannels\WebPush\WebPushMessage;

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
        // $this->fakeData();


        $userLogs = $this->getUserActivites();

        return view('pages/dashboard/index', [
            'title' => $this->modelName,
            'userLogs' => $userLogs,
        ]);
    }

    private function getUserActivites()
    {
        $logs = DB::table('user_logs')
            ->where('log_action', '!=', 'View')
            ->orderBy('created_at', 'desc')
            ->take(100)
            ->join('users as ut', 'ut.id', '=', 'user_logs.user_id')
            ->get([
                'user_logs.user_id',
                'user_logs.user_name',
                'user_logs.form_name',
                'user_logs.form_record_id',
                'user_logs.log_action',
                'user_logs.created_at',
                'ut.img' // Image field from users
            ]);

        // Manually apply the image logic
        $defaultImage = 'https://hancockogundiyapartners.com/wp-content/uploads/2019/07/dummy-profile-pic-300x300.jpg';

        $userLogs = $logs->transform(function ($log) use ($defaultImage) {
            $log->img = !empty($log->img) && Storage::exists('public/' . $log->img)
                ? asset('storage/' . $log->img)
                : $defaultImage;
            return $log;
        });

        return $userLogs;
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
}
