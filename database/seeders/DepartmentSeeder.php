<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Branch\Branch;
use Illuminate\Database\Seeder;
use App\Models\Department\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'branch_name' => 'Dubai',
                'branch_code' => 'DXB',
                'location_address' => '123 Sheikh Zayed Road',
                'city' => 'Dubai',
                'state' => 'Dubai',
                'country' => 'UAE',
                'postal_code' => '00001',
                'phone_number' => '1234567890',
                'email' => 'dubai@example.com',
                'opening_date' => now(),
                'is_active' => true,
                'notes' => 'Main branch in Dubai',
            ],
            [
                'branch_name' => 'Saudi Arabia',
                'branch_code' => 'KSA',
                'location_address' => 'King Fahd Road',
                'city' => 'Riyadh',
                'state' => 'Riyadh',
                'country' => 'Saudi Arabia',
                'postal_code' => '11564',
                'phone_number' => '1234567891',
                'email' => 'saudi@example.com',
                'opening_date' => now(),
                'is_active' => true,
                'notes' => 'Branch in Saudi Arabia',
            ],
            [
                'branch_name' => 'Oman',
                'branch_code' => 'OMN',
                'location_address' => 'Al Khuwair Street',
                'city' => 'Muscat',
                'state' => 'Muscat',
                'country' => 'Oman',
                'postal_code' => '111',
                'phone_number' => '1234567892',
                'email' => 'oman@example.com',
                'opening_date' => now(),
                'is_active' => true,
                'notes' => 'Branch in Oman',
            ],
            [
                'branch_name' => 'Qatar',
                'branch_code' => 'QAT',
                'location_address' => 'Corniche Street',
                'city' => 'Doha',
                'state' => 'Doha',
                'country' => 'Qatar',
                'postal_code' => '122',
                'phone_number' => '1234567893',
                'email' => 'qatar@example.com',
                'opening_date' => now(),
                'is_active' => true,
                'notes' => 'Branch in Qatar',
            ],
            [
                'branch_name' => 'India',
                'branch_code' => 'IND',
                'location_address' => 'MG Road',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'postal_code' => '560001',
                'phone_number' => '1234567894',
                'email' => 'india@example.com',
                'opening_date' => now(),
                'is_active' => true,
                'notes' => 'Branch in India',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['branch_name' => $branch['branch_name']], // Base condition to check if exists
                $branch // Values to create or update
            );
        }

        $departments = [
            [
                'department_name' => 'Management',
                'department_code' => 'MGMT',
                'description' => 'Management department',
                'branch_id' => 1, // You can change this based on your branch data
                'email' => 'management@example.com',
                'phone_number' => '1234567890',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles company management',
            ],
            [
                'department_name' => 'Development',
                'department_code' => 'DEV',
                'description' => 'Development department',
                'branch_id' => 1,
                'email' => 'development@example.com',
                'phone_number' => '1234567891',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles all software development',
            ],
            [
                'department_name' => 'Sales',
                'department_code' => 'SALES',
                'description' => 'Sales department',
                'branch_id' => 1,
                'email' => 'sales@example.com',
                'phone_number' => '1234567892',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles sales and customer relations',
            ],
            [
                'department_name' => 'Finance',
                'department_code' => 'FIN',
                'description' => 'Finance department',
                'branch_id' => 1,
                'email' => 'finance@example.com',
                'phone_number' => '1234567893',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles financial operations',
            ],
            [
                'department_name' => 'Administration',
                'department_code' => 'ADMIN',
                'description' => 'Administration department',
                'branch_id' => 1,
                'email' => 'admin@example.com',
                'phone_number' => '1234567894',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles administrative tasks',
            ],
            [
                'department_name' => 'IT Infrastructure',
                'department_code' => 'ITINFRA',
                'description' => 'IT Infrastructure department',
                'branch_id' => 1,
                'email' => 'itinfra@example.com',
                'phone_number' => '1234567895',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles IT infrastructure and systems',
            ],
            [
                'department_name' => 'Hardware',
                'department_code' => 'HARD',
                'description' => 'Hardware department',
                'branch_id' => 1,
                'email' => 'hardware@example.com',
                'phone_number' => '1234567896',
                'established_date' => now(),
                'is_active' => true,
                'notes' => 'Handles hardware-related tasks',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['department_name' => $department['department_name']], // Base condition to check if exists
                $department // Values to create or update
            );
        }
    }
}
