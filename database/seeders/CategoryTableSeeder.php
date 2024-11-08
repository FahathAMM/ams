<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\asset\AssetCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetCategory::create(['name' => 'Laptop']);
        AssetCategory::create(['name' => 'Computer']);
        AssetCategory::create(['name' => 'Server']);
        AssetCategory::create(['name' => 'Switches']);
        AssetCategory::create(['name' => 'Accesspoint']);
        AssetCategory::create(['name' => 'Firewall']);
        AssetCategory::create(['name' => 'Printers']);
        AssetCategory::create(['name' => 'TV']);
        AssetCategory::create(['name' => 'IP phones']);
        AssetCategory::create(['name' => 'Mobile devices']);
    }
}
