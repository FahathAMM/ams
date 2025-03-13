<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeesTableSeeder_copy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('employees')->truncate();

        $faker = Factory::create();

        $emp = [
            'Fahath',
            'Nilesh',
            'Amritha',
            'Dincy',
            'Glenn',
            'Ronald',
            'Shabin',
            'Bindal',
            'Dileep',
            'Jithenthran',
            'Archana',
            'Disha',
            'Arun',
            'Binoy',
            'Sharika',
            'Nashmin',
            'Nimitha',
            'Eliza',
            'Suranjith',
        ];


        for ($i = 0; $i < count($emp); $i++) {
            $empObj = Employee::create([
                'first_name' => $emp[$i],
                'last_name' => '',
                'username' =>  $emp[$i],
                'password' => ("$emp[$i]@123"),
                'emp_number' => 'EMP' . $faker->unique()->numberBetween(1000, 9999),
                'designation' => $faker->jobTitle,
                'phone_number' => $faker->phoneNumber,
                'email' => 'employee' . $i . '@example.com',
                'branch_id' => 3,
                'department_id' => 'IT',
                'joining_date' => $faker->date,
                'country' => $faker->country,
                'img' => null,
                'cover_img' => 'cover_img_path_' . $i,
                'description' => $faker->sentence,
            ]);

            $this->createUserByEmployee($empObj, $empObj->id);
        }
    }

    public function createUserByEmployee($empObj, $empId)
    {
        try {
            $data = $empObj;
            // dd($data);
            $data['employee_id'] = $empId;
            User::create($data);
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }
}
