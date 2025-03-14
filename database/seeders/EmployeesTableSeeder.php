<?php

namespace Database\Seeders;

use App\Models\Branch\Branch;
use App\Models\Department\Department;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeesTableSeeder extends Seeder
{
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('employees')->truncate();
        // DB::table('users')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Factory::create();

        $employees = [
            [
                'first_name' => 'Fahath',
                'last_name' => '',
                'username' => 'Fahath',
                'password' => 'Fahath@123',
                'emp_number' => 'EMP1001',
                'designation' => 'Software Developer',
                'phone_number' => '123-456-7890',
                'email' => 'fahath@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2023-05-10',
                'country' => 'Sri Lanka',
                'img' => null,
                'cover_img' => 'cover_img_path_0',
                'description' => 'Skilled software developer with expertise in PHP and Laravel.',
            ],
            [
                'first_name' => 'Nilesh',
                'last_name' => '',
                'username' => 'Nilesh',
                'password' => 'Nilesh@123',
                'emp_number' => 'EMP1002',
                'designation' => 'Project Manager',
                'phone_number' => '123-456-7891',
                'email' => 'nilesh@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2023-06-12',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_1',
                'description' => 'Experienced project manager leading IT projects.',
            ],
            [
                'first_name' => 'Amritha',
                'last_name' => '',
                'username' => 'Amritha',
                'password' => 'Amritha@123',
                'emp_number' => 'EMP1003',
                'designation' => 'Business Analyst',
                'phone_number' => '123-456-7892',
                'email' => 'amritha@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2023-07-15',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_2',
                'description' => 'Analytical thinker with a focus on business solutions.',
            ],
            [
                'first_name' => 'Dincy',
                'last_name' => '',
                'username' => 'Dincy',
                'password' => 'Dincy@123',
                'emp_number' => 'EMP1004',
                'designation' => 'UX Designer',
                'phone_number' => '123-456-7893',
                'email' => 'dincy@example.com',
                'branch_id' => 3,
                'department_id' => 'Design',
                'joining_date' => '2023-08-01',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_3',
                'description' => 'Creative designer focused on user experiences.',
            ],
            [
                'first_name' => 'Glenn',
                'last_name' => '',
                'username' => 'Glenn',
                'password' => 'Glenn@123',
                'emp_number' => 'EMP1005',
                'designation' => 'DevOps Engineer',
                'phone_number' => '123-456-7894',
                'email' => 'glenn@example.com',
                'branch_id' => 3,
                'department_id' => 'Operations',
                'joining_date' => '2023-04-17',
                'country' => 'Philippines',
                'img' => null,
                'cover_img' => 'cover_img_path_4',
                'description' => 'DevOps engineer streamlining CI/CD processes.',
            ],
            [
                'first_name' => 'Ronald',
                'last_name' => '',
                'username' => 'Ronald',
                'password' => 'Ronald@123',
                'emp_number' => 'EMP1006',
                'designation' => 'Software Tester',
                'phone_number' => '123-456-7895',
                'email' => 'ronald@example.com',
                'branch_id' => 3,
                'department_id' => 'Quality Assurance',
                'joining_date' => '2023-09-21',
                'country' => 'Sri Lanka',
                'img' => null,
                'cover_img' => 'cover_img_path_5',
                'description' => 'Detail-oriented software tester with automation skills.',
            ],
            [
                'first_name' => 'Shabin',
                'last_name' => '',
                'username' => 'Shabin',
                'password' => 'Shabin@123',
                'emp_number' => 'EMP1007',
                'designation' => 'Network Engineer',
                'phone_number' => '123-456-7896',
                'email' => 'shabin@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2023-10-05',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_6',
                'description' => 'Specialist in network infrastructure and security.',
            ],
            [
                'first_name' => 'Bindal',
                'last_name' => '',
                'username' => 'Bindal',
                'password' => 'Bindal@123',
                'emp_number' => 'EMP1008',
                'designation' => 'HR Specialist',
                'phone_number' => '123-456-7897',
                'email' => 'bindal@example.com',
                'branch_id' => 3,
                'department_id' => 'HR',
                'joining_date' => '2023-11-02',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_7',
                'description' => 'Experienced HR specialist focusing on recruitment.',
            ],
            [
                'first_name' => 'Dileep',
                'last_name' => '',
                'username' => 'Dileep',
                'password' => 'Dileep@123',
                'emp_number' => 'EMP1009',
                'designation' => 'Database Administrator',
                'phone_number' => '123-456-7898',
                'email' => 'dileep@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2023-12-12',
                'country' => 'Sri Lanka',
                'img' => null,
                'cover_img' => 'cover_img_path_8',
                'description' => 'Database management and optimization expert.',
            ],
            [
                'first_name' => 'Jithenthran',
                'last_name' => '',
                'username' => 'Jithenthran',
                'password' => 'Jithenthran@123',
                'emp_number' => 'EMP1010',
                'designation' => 'Frontend Developer',
                'phone_number' => '123-456-7800',
                'email' => 'jithenthran@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2024-01-03',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_9',
                'description' => 'Experienced frontend developer specializing in Vue.js.',
            ],
            [
                'first_name' => 'Archana',
                'last_name' => '',
                'username' => 'Archana',
                'password' => 'Archana@123',
                'emp_number' => 'EMP1011',
                'designation' => 'UI/UX Designer',
                'phone_number' => '123-456-7801',
                'email' => 'archana@example.com',
                'branch_id' => 3,
                'department_id' => 'Design',
                'joining_date' => '2024-01-08',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_10',
                'description' => 'Creative designer focused on enhancing user experience.',
            ],
            [
                'first_name' => 'Disha',
                'last_name' => '',
                'username' => 'Disha',
                'password' => 'Disha@123',
                'emp_number' => 'EMP1012',
                'designation' => 'Marketing Specialist',
                'phone_number' => '123-456-7802',
                'email' => 'disha@example.com',
                'branch_id' => 3,
                'department_id' => 'Marketing',
                'joining_date' => '2024-02-01',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_11',
                'description' => 'Specialist in digital marketing and campaign strategies.',
            ],
            [
                'first_name' => 'Arun',
                'last_name' => '',
                'username' => 'Arun',
                'password' => 'Arun@123',
                'emp_number' => 'EMP1013',
                'designation' => 'Data Scientist',
                'phone_number' => '123-456-7803',
                'email' => 'arun@example.com',
                'branch_id' => 3,
                'department_id' => 'Data Science',
                'joining_date' => '2024-02-15',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_12',
                'description' => 'Expert in data analysis and machine learning.',
            ],
            [
                'first_name' => 'Binoy',
                'last_name' => '',
                'username' => 'Binoy',
                'password' => 'Binoy@123',
                'emp_number' => 'EMP1014',
                'designation' => 'System Administrator',
                'phone_number' => '123-456-7804',
                'email' => 'binoy@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => '2024-03-01',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_13',
                'description' => 'Ensures system stability and security.',
            ],
            [
                'first_name' => 'Sharika',
                'last_name' => '',
                'username' => 'Sharika',
                'password' => 'Sharika@123',
                'emp_number' => 'EMP1015',
                'designation' => 'Content Writer',
                'phone_number' => '123-456-7805',
                'email' => 'sharika@example.com',
                'branch_id' => 3,
                'department_id' => 'Content',
                'joining_date' => '2024-03-10',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_14',
                'description' => 'Creative content writer and editor.',
            ],
            [
                'first_name' => 'Nashmin',
                'last_name' => '',
                'username' => 'Nashmin',
                'password' => 'Nashmin@123',
                'emp_number' => 'EMP1016',
                'designation' => 'Operations Manager',
                'phone_number' => '123-456-7806',
                'email' => 'nashmin@example.com',
                'branch_id' => 3,
                'department_id' => 'Operations',
                'joining_date' => '2024-03-15',
                'country' => 'Sri Lanka',
                'img' => null,
                'cover_img' => 'cover_img_path_15',
                'description' => 'Experienced in handling daily operations efficiently.',
            ],
            [
                'first_name' => 'Nimitha',
                'last_name' => '',
                'username' => 'Nimitha',
                'password' => 'Nimitha@123',
                'emp_number' => 'EMP1017',
                'designation' => 'Financial Analyst',
                'phone_number' => '123-456-7807',
                'email' => 'nimitha@example.com',
                'branch_id' => 3,
                'department_id' => 'Finance',
                'joining_date' => '2024-03-22',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_16',
                'description' => 'Analyzes financial data to guide decision-making.',
            ],
            [
                'first_name' => 'Eliza',
                'last_name' => '',
                'username' => 'Eliza',
                'password' => 'Eliza@123',
                'emp_number' => 'EMP1018',
                'designation' => 'Sales Executive',
                'phone_number' => '123-456-7808',
                'email' => 'eliza@example.com',
                'branch_id' => 3,
                'department_id' => 'Sales',
                'joining_date' => '2024-04-01',
                'country' => 'India',
                'img' => null,
                'cover_img' => 'cover_img_path_17',
                'description' => 'Skilled in client engagement and sales strategies.',
            ],
            [
                'first_name' => 'Suranjith',
                'last_name' => '',
                'username' => 'Suranjith',
                'password' => 'Suranjith@123',
                'emp_number' => 'EMP1019',
                'designation' => 'Customer Support',
                'phone_number' => '123-456-7809',
                'email' => 'suranjith@example.com',
                'branch_id' => 3,
                'department_id' => 'Support',
                'joining_date' => '2024-04-05',
                'country' => 'Sri Lanka',
                'img' => null,
                'cover_img' => 'cover_img_path_18',
                'description' => 'Dedicated to providing excellent customer support.',
            ],
        ];

        $depId = Department::where('department_name', 'Development')->first()->id;
        $branId = Branch::where('branch_name', 'Dubai')->first()->id;

        try {
            foreach ($employees as $employee) {
                $empObj = Employee::create([
                    'first_name' => $employee['first_name'],
                    'last_name' => $employee['last_name'],
                    'username' => $employee['username'],
                    'password' => $employee['password'],
                    'emp_number' => $employee['emp_number'],
                    'designation' => $employee['designation'],
                    'phone_number' => $employee['phone_number'],
                    'email' => $employee['email'],
                    'branch_id' => $branId,
                    'department_id' => $depId,
                    'joining_date' => $employee['joining_date'],
                    'country' => $employee['country'],
                    'img' => $employee['img'],
                    'cover_img' => $employee['cover_img'],
                    'description' => $employee['description'],
                ]);

                $this->createUserByEmployee($empObj, $empObj->id);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createUserByEmployee($empObj, $empId)
    {
        try {
            $data = [
                'title' => $empObj->title ?? null,
                'first_name' => $empObj->first_name,
                'last_name' => $empObj->last_name,
                'username' => $empObj->username,
                'password' => $empObj->password,
                'email' => $empObj->email,
                'designation' => $empObj->designation,
                'contact' => $empObj->phone_number ?? null,
                'branch' => $empObj->branch_id ?? null,
                'img' => $empObj->img ?? null,
                'joining_date' => $empObj->joining_date,
                'is_active' => $empObj->is_active ?? 1,
                'description' => $empObj->description,
                'role_id' => 1,
                'employee_id' => $empId,
            ];

            User::create($data);
        } catch (\Exception $th) {
            Log::error("Failed to create user for employee ID $empId: " . $th->getMessage());
        }
    }
}
