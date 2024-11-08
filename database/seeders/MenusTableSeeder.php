<?php

namespace Database\Seeders;

use App\Models\Menu\MenuDetail;
use App\Models\Menu\MenuHeader;
use Illuminate\Database\Seeder;
use App\Models\Menu\MenuSubDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('menu_headers')->truncate();
        DB::table('menu_details')->truncate();
        DB::table('menu_sub_details')->truncate();

        $menuHeaderDashboard = MenuHeader::create([
            'name1' => 'Dashboards',
            'name2' => 'Dashboards',
            'is_active' => 1,
            'icon' => 'ri-dashboard-2-line',
            'menu_code' => 1,
            'menu' => json_encode(['item1' => 'value1', 'item2' => 'value2']),
        ]);

        $menuHeaderOrg = MenuHeader::create([
            'name1' => 'Organization',
            'name2' => 'Organization',
            'is_active' => 1,
            'icon' => 'ri-dashboard-2-line',
            'menu_code' => 100,
            'menu' => json_encode(['item1' => 'value1', 'item2' => 'value2']),
        ]);

        $menuHeaderAdministration = MenuHeader::create([
            'name1' => 'Administration',
            'name2' => 'Administration',
            'is_active' => 1,
            'icon' => 'ri-admin-line',
            'menu_code' => 300,
            'menu' => json_encode(['item1' => 'value1', 'item2' => 'value2']),
        ]);

        $menuDetails = [
            [
                'menu_header_id' => $menuHeaderOrg->id,
                'name1' => 'Employee',
                'name2' => 'Employee',
                'sequence' => '1',
                'page_url' => '#',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-user-line',
            ],

            [
                'menu_header_id' => $menuHeaderOrg->id,
                'name1' => 'Asset',
                'name2' => 'Asset',
                'sequence' => '1',
                'page_url' => '#',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],


            //menuHeaderAdministration

            [
                'menu_header_id' => $menuHeaderAdministration->id,
                'name1' => 'Users',
                'name2' => 'Users',
                'sequence' => '1',
                'page_url' => 'administration/user',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-user-line',
            ],
            [
                'menu_header_id' => $menuHeaderAdministration->id,
                'name1' => 'Role',
                'name2' => 'Role',
                'sequence' => '2',
                'page_url' => 'administration/role',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-shield-user-line',
            ],
            [
                'menu_header_id' => $menuHeaderAdministration->id,
                'name1' => 'Permission',
                'name2' => 'Permission',
                'sequence' => '2',
                'page_url' => 'administration/permission',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-shield-keyhole-line',
            ],
        ];

        MenuDetail::insert($menuDetails);


        // MenuSubDetail::create([
        //     'menu_detail_id' => 6,
        //     'name1' => 'Shipment',
        //     'name2' => 'Shipment',
        //     'sequence' => '1',
        //     'page_url' => '#',
        //     'is_active' => 1,
        //     'icon' => 'ri-ship-line',
        // ]);

        // MenuSubDetail::create([
        //     'menu_detail_id' => 6,
        //     'name1' => 'Delivery',
        //     'name2' => 'Delivery',
        //     'sequence' => '1',
        //     'page_url' => '#',
        //     'is_active' => 1,
        //     'icon' => 'ri-truck-line',
        // ]);

        generateMenuSlug();
    }
}
