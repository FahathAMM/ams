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
        // return;
        $menuHeaderDashboard = MenuHeader::updateOrCreate(
            ['menu_code' => 1],
            [
                'name1' => 'Dashboards',
                'name2' => 'Dashboards',
                'is_active' => 1,
                'icon' => 'ri-dashboard-2-line',
                'menu' => "",
            ]
        );

        $menuHeaderOrg = MenuHeader::updateOrCreate(
            ['menu_code' => 100],
            [
                'name1' => 'Organization',
                'name2' => 'Organization',
                'is_active' => 1,
                'icon' => 'ri-dashboard-2-line',
                'menu' => "",
            ]
        );

        $menuHeaderAms = MenuHeader::updateOrCreate(
            ['menu_code' => 200],
            [
                'name1' => 'Assets',
                'name2' => 'Assets',
                'is_active' => 1,
                'icon' => 'ri-dashboard-2-line',
                'menu' => "",
            ]
        );

        $menuHeaderWrkbase = MenuHeader::updateOrCreate(
            ['menu_code' => 300],
            [
                'name1' => 'Workbase',
                'name2' => 'Workbase',
                'is_active' => 1,
                'icon' => 'ri-dashboard-2-line',
                'menu' => "",
            ]
        );

        $menuHeaderLeave = MenuHeader::updateOrCreate(
            ['menu_code' => 400],
            [
                'name1' => 'Leave',
                'name2' => 'Leave',
                'is_active' => 1,
                'icon' => 'ri-dashboard-2-line',
                'menu' => "",
            ]
        );

        $menuHeaderRoomease = MenuHeader::updateOrCreate(
            ['menu_code' => 500],
            [
                'name1' => 'Roomease',
                'name2' => 'Roomease',
                'is_active' => 1,
                'icon' => 'ri-dashboard-2-line',
                'menu' => "",
            ]
        );

        $menuHeaderAdministration = MenuHeader::updateOrCreate(
            ['menu_code' => 600],
            [
                'name1' => 'Administration',
                'name2' => 'Administration',
                'is_active' => 1,
                'icon' => 'ri-admin-line',
                'menu' => "",
            ]
        );

        // $menuHeaderAdministration = MenuHeader::updateOrCreate(
        //     ['menu_code' => 700],
        //     [
        //         'name1' => 'Administration11',
        //         'name2' => 'Administration11',
        //         'is_active' => 1,
        //         'icon' => 'ri-admin-line',
        //         'menu' => "",
        //     ]
        // );

        $menuDetails = [
            [
                'menu_header_id' => $menuHeaderOrg->id,
                'name1' => 'Employee',
                'name2' => 'Employee',
                'sequence' => '1',
                'page_url' => 'organization/employee',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-user-line',
            ],

            [
                'menu_header_id' => $menuHeaderOrg->id,
                'name1' => 'Customer',
                'name2' => 'Customer',
                'sequence' => '2',
                'page_url' => 'organization/customer',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-user-line',
            ],

            [
                'menu_header_id' => $menuHeaderOrg->id,
                'name1' => 'Branch',
                'name2' => 'Branch',
                'sequence' => '4',
                'page_url' => 'organization/branch',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            [
                'menu_header_id' => $menuHeaderOrg->id,
                'name1' => 'Department',
                'name2' => 'Department',
                'sequence' => '5',
                'page_url' => 'organization/department',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            //menuHeaderAMS

            [
                'menu_header_id' => $menuHeaderAms->id,
                'name1' => 'Asset',
                'name2' => 'Asset',
                'sequence' => '1',
                'page_url' => 'assets/asset',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            [
                'menu_header_id' => $menuHeaderAms->id,
                'name1' => 'Asset Assign',
                'name2' => 'Asset Assign',
                'sequence' => '2',
                'page_url' => 'assets/asset-assign',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            //menuHeaderWrkbase

            [
                'menu_header_id' => $menuHeaderWrkbase->id,
                'name1' => 'EOD',
                'name2' => 'EOD',
                'sequence' => '1',
                'page_url' => 'workbase/eodreport',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            [
                'menu_header_id' => $menuHeaderWrkbase->id,
                'name1' => 'Daily Completion',
                'name2' => 'EOD',
                'sequence' => '2',
                'page_url' => 'workbase/eodlist',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],
            [
                'menu_header_id' => $menuHeaderWrkbase->id,
                'name1' => 'Assign EOD Reporting Manager',
                'name2' => 'EOD',
                'sequence' => '3',
                'page_url' => 'workbase/eod-assign',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            // menuHeaderRoomease
            [
                'menu_header_id' => $menuHeaderRoomease->id,
                'name1' => 'Apartment',
                'name2' => 'Apartment',
                'sequence' => '1',
                'page_url' => 'roomease/apartment',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],

            // menuHeaderLeave

            [
                'menu_header_id' => $menuHeaderLeave->id,
                'name1' => 'Leave Type',
                'name2' => 'Leave Type',
                'sequence' => '1',
                'page_url' => 'leave/leave-type',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],
            [
                'menu_header_id' => $menuHeaderLeave->id,
                'name1' => 'Apply Leave',
                'name2' => 'Apply Leave',
                'sequence' => '2',
                'page_url' => 'leave/leave',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],
            [
                'menu_header_id' => $menuHeaderLeave->id,
                'name1' => 'Request Leave List',
                'name2' => 'Request Leave List',
                'sequence' => '2',
                'page_url' => 'leave/leave-list',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => ' ri-computer-line',
            ],
            [
                'menu_header_id' => $menuHeaderLeave->id,
                'name1' => 'My Leave',
                'name2' => 'My Leave',
                'sequence' => '2',
                'page_url' => 'leave/leave',
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
                'sequence' => '3',
                'page_url' => 'administration/permission',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-shield-keyhole-line',
            ],
            [
                'menu_header_id' => $menuHeaderAdministration->id,
                'name1' => 'User Activty',
                'name2' => 'User Activty',
                'sequence' => '4',
                'page_url' => 'administration/user-activity',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-contacts-fill',
            ],
            [
                'menu_header_id' => $menuHeaderAdministration->id,
                'name1' => 'Logged User Tracking',
                'name2' => 'Logged User Tracking',
                'sequence' => '5',
                'page_url' => 'administration/logged-user-tracking',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-contacts-fill',
            ],
            [
                'menu_header_id' => $menuHeaderAdministration->id,
                'name1' => 'Setting',
                'name2' => 'Setting',
                'sequence' => '6',
                'page_url' => 'administration/setting',
                'is_submenu_available' => 0,
                'is_active' => 1,
                'icon' => 'ri-settings-5-line',
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
