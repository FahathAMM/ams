<?php

namespace Database\Seeders;

use App\Models\Leave\LeaveType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveType::insert([
            [
                'name' => 'Sick Leave',
                'number_of_days' => 12,
                'description' => 'Per person can take 12 days sick leave with paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Annual Vacation',
                'number_of_days' => 30,
                'description' => 'Per person can take 30 days paid vacation leave',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maternity Leave',
                'number_of_days' => 45,
                'description' => 'Per female employee can take 45 days paid maternity leave',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paternity Leave',
                'number_of_days' => 5,
                'description' => 'Per male employee can take 5 days paid paternity leave',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emergency Leave',
                'number_of_days' => 7,
                'description' => 'Per person can take 7 days emergency leave without pay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hajj Leave',
                'number_of_days' => 30,
                'description' => 'Per person can take 30 days unpaid leave for pilgrimage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Study Leave',
                'number_of_days' => 10,
                'description' => 'Per person can take 10 days unpaid leave for studies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Compensatory Leave',
                'number_of_days' => 0,
                'description' => 'Leave provided in exchange for overtime work; paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
