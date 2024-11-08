<?php

namespace Database\Seeders;

use App\Models\Asset\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('attributes')->truncate();

        Attribute::create(['name' => 'RAM']);
        Attribute::create(['name' => 'Color']);
        Attribute::create(['name' => 'Storage']);
        Attribute::create(['name' => 'Operating System']);
        Attribute::create(['name' => 'Windows Activation']);
        Attribute::create(['name' => 'Office version']);
        Attribute::create(['name' => 'Accessories Item']);
    }


}
