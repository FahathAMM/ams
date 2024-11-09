<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\EmployeesTableSeeder;
use Database\Seeders\AttributesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('employees')->truncate();
        DB::table('users')->truncate();
        DB::table('asset_categories')->truncate();
        DB::table('branches')->truncate();
        DB::table('departments')->truncate();
        DB::table('attributes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            DepartmentSeeder::class,
            AttributesTableSeeder::class,
            CategoryTableSeeder::class,
            EmployeesTableSeeder::class,
            UsersTableSeeder::class,
            MenusTableSeeder::class,
        ]);
    }
}
