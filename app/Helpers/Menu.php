<?php

use App\Models\User;
use App\Models\Menu\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

if (!function_exists('menu')) {
    function menu()
    {
        // generateMenuSlug();

        return session('menus');

        // $HeaderMenu =  DB::table('menu_headers')->get();
        // $DetailMenu =   DB::table('menu_details')->where('is_active', 1)->get();
        // $SubMenuDetail =   DB::table('menu_sub_details')->get();
        // // generateMenuSlug();
        // return [
        //     'HeaderMenu' => $HeaderMenu,
        //     'DetailMenu' => $DetailMenu,
        //     'SubMenuDetail' => $SubMenuDetail,
        // ];
    }
}

if (!function_exists('getMenu')) {
    function getMenu()
    {
        // Check if the logged-in user has a "super-admin" role
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super-Admin');

        // If the user is not a super-admin, filter based on permissions
        if (!$isSuperAdmin) {
            $LoggedUserAccesspermissions = collect($user->getPermissionsViaRoles()->toArray())
                ->pluck('name')
                ->filter(fn($permission) => str_contains($permission, '-view'))
                ->map(fn($permission) => str_replace('-view', '', $permission))
                ->unique()
                ->values()
                ->toArray();
        } else {
            // If user is a super-admin, allow access to all menus
            $LoggedUserAccesspermissions = [];
        }

        // Retrieve the header menu
        $HeaderMenu =  DB::table('menu_headers')->orderBy('sequence', 'asc')->where('is_active', 1)->get();

        // Retrieve the detail menu with or without permission filtering
        $DetailMenu = DB::table('menu_details')
            ->where('is_active', 1)
            ->when(!$isSuperAdmin, function ($query) use ($LoggedUserAccesspermissions) {
                $query->where(function ($q) use ($LoggedUserAccesspermissions) {
                    $q->whereIn('menu_slug', $LoggedUserAccesspermissions)
                        ->orWhere('is_submenu_available', 1);
                });
            })
            ->orderBy('sequence', 'asc')
            ->get();

        // Retrieve the sub-menu detail with or without permission filtering
        $SubMenuDetail = DB::table('menu_sub_details')
            ->where('is_active', 1)
            ->when(!$isSuperAdmin, function ($query) use ($LoggedUserAccesspermissions) {
                $query->whereIn('menu_slug', $LoggedUserAccesspermissions);
            })
            ->get();

        // Organize the menus into an array
        $menus = [
            'HeaderMenu' => $HeaderMenu,
            'DetailMenu' => $DetailMenu,
            'SubMenuDetail' => $SubMenuDetail,
        ];

        // Store the menus in session
        session(['menus' => $menus]);

        return $menus;
    }
}

if (!function_exists('generateMenuSlug')) {
    function generateMenuSlug()
    {
        $detailMenus = DB::table('menu_details')->get();
        $menuHeaders = DB::table('menu_headers')->pluck('name1', 'id')->toArray();

        $detailMenus = $detailMenus->merge(aditionalMenu());
        // $detailMenus;

        // dd($detailMenus);

        foreach ($detailMenus as $menu) {
            $moduleName = $menuHeaders[$menu->menu_header_id];
            $slug = Str::lower($moduleName) . '-' . Str::slug($menu->name1);

            DB::table('menu_details')
                ->where('id', $menu->id)
                ->update(['menu_slug' => $slug]);

            if ($menu->is_submenu_available) {
                $subMenuRows = DB::table('menu_sub_details')
                    ->where('menu_detail_id', $menu->id)
                    ->get();

                foreach ($subMenuRows as $subMenu) {
                    $subMenuName = $subMenu->name1;
                    $subMenuSlug = $slug . '-' . Str::slug($subMenuName);
                    DB::table('menu_sub_details')
                        ->where('id', $subMenu->id)
                        ->update(['menu_slug' => $subMenuSlug]);

                    $actionArr = ['view', 'create', 'edit', 'delete'];
                    foreach ($actionArr as $value) {
                        $perSlug = $subMenuSlug . '-' . $value;
                        Permission::updateOrCreate(['name' => $perSlug], ['name' => $perSlug]);
                    }
                }
            }

            $actionArr = ['view', 'create', 'edit', 'delete'];
            foreach ($actionArr as $value) {
                $perSlug = $slug . '-' . $value;
                Permission::updateOrCreate(['name' => $perSlug], ['name' => $perSlug]);
            }
        }
    }
}

if (!function_exists('aditionalMenu')) {
    function aditionalMenu()
    {
        return [
            // (object) [
            //     'id' => 189,
            //     'menu_header_id' => 3,
            //     'name1' => 'User Control-Panel',
            //     'name2' => 'User Control-Panel',
            //     'sequence' => '10',
            //     'menu_slug' => 'administration-user-control-panel',
            //     'page_url' => '#',
            //     'is_submenu_available' => 0,
            //     'is_active' => 0,
            //     'icon' => 'ri-download-cloud-2-fill',

            //     // for permission list menu array
            //     'moduleName' => 'Administration',
            //     'MenuId' =>  3,
            //     'MenuDetailId' =>  '',
            //     'MenuDetailSequence' =>  '',
            //     'perSlug' =>  'administration-user-control-panel',
            //     'subMenuDetailId' =>  '',
            //     'menuName' =>  'User Control-Panel',
            //     'isSubMenu' =>  0,
            //     'subMenuSequence' =>  '',
            //     // 'perSlug' =>  'administration-user-setting',
            // ]
        ];
    }
}

if (!function_exists('getMenuBkp')) {
    function getMenuBkp()
    {
        // $permissions = array_column(Role::find(currentUserID())->permissions->toArray(), 'name');

        // $modifiedPermissions = collect($permissions)
        //     ->filter(function ($permission) {
        //         // Only keep permissions with 'view' in them
        //         return str_contains($permission, '-view');
        //     })
        //     ->map(function ($permission) {
        //         // Remove the '-view' suffix
        //         return str_replace('-view', '', $permission);
        //     })->values()
        //     ->toArray();


        $HeaderMenu =  DB::table('menu_headers')->where('is_active', 1)->get();
        $DetailMenu =   DB::table('menu_details')->where('is_active', 1)->orderBy('sequence', 'asc')->get();
        $SubMenuDetail =   DB::table('menu_sub_details')->where('is_active', 1)->get();
        // generateMenuSlug();

        $menus = [
            'HeaderMenu' => $HeaderMenu,
            'DetailMenu' => $DetailMenu,
            'SubMenuDetail' => $SubMenuDetail,
        ];

        session(['menus' => $menus]);

        return $menus;
    }
}
