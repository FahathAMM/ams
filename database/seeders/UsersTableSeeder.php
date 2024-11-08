<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Developer']);
        Role::create(['name' => 'Manager']);
        $superAdmin = Role::create(['name' => 'Super-Admin']);

        $user = User::create(
            [
                'title' => 'Ms.',
                'first_name' => 'Super Admin',
                'username' => 'superadmin',
                'designation' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'email_verified_at' => now(),
                'password' => 'Admin@123',
                'contact' => '0987654321',
                'branch' => '1',
                'img' => '',
                'is_active' => 1,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'role_id' => 2,

            ]
        );

        $user->assignRole($superAdmin->name);

        // \App\Models\User::factory(50)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
