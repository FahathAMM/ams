<?php

namespace App\Repositories\Administration;

use App\Models\Menu\MenuHeader;
use Spatie\Permission\Models\Role;
use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepo extends BaseRepository
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
    public function getPermissionListByRole($roleId)
    {
        return Role::find($roleId)->permissions->pluck('name')->toArray();
    }

    public function getMenuList()
    {
        $menus = MenuHeader::query()
            ->select(
                'menu_headers.id as menuid',
                'menu_headers.name1 as menuname1',
                'md.id as menudetailid',
                'md.name1 as menudetailname1',
                'md.is_submenu_available',
                'msd.id as submenudetailid',
                'msd.name1 as submenudetailname1',
                'md.sequence as menusequence',
                'msd.sequence as submenusequence',
                'msd.menu_slug as menu_sub_slug',
                'md.menu_slug as menu_d_slug'
            )
            ->leftJoin('menu_details as md', 'menu_headers.id', '=', 'md.menu_header_id')
            ->leftJoin('menu_sub_details as msd', 'md.id', '=', 'msd.menu_detail_id')
            ->orderBy('md.id', 'asc')
            ->get();

        return $this->transformMenus($menus);;
    }

    private function transformMenus($menus)
    {
        $menuList = $menus->reject(function ($menu) {
            return $menu->menuname1 == 'Dashboards';
        })->map(function ($menu) {
            return [
                'moduleName' => $menu->menuname1,
                'MenuId' => $menu->menuid,
                'MenuDetailId' => $menu->menudetailid,
                'MenuDetailSequence' => $menu->menusequence,
                'perSlug' => $menu->menu_d_slug,
                'subMenuDetailId' => $menu->is_submenu_available ? $menu->submenudetailid : '',
                'menuName' => $menu->is_submenu_available ? $menu->submenudetailname1 : $menu->menudetailname1,
                'isSubMenu' => $menu->is_submenu_available ? 1 : 0,
                'subMenuSequence' => $menu->is_submenu_available ? $menu->submenudetailid : PHP_INT_MAX,
                'perSlug' => $menu->is_submenu_available ? $menu->menu_sub_slug : $menu->menu_d_slug,
            ];
        });

        $menuList = $menuList->merge(aditionalMenu());
        return json_decode(json_encode($menuList), true);
        // return $menuList;
    }

    public function generateFormHiddenFields($menu)
    {
        return $menu['menuName'] . '
            <input type="hidden" id="MenuSlug" name="perSlug[]" value="' . $menu['perSlug'] . '" >
            <input type="hidden" id="ModuleName" name="MenuId[]" value="' . $menu['moduleName'] . '" >
            <input type="hidden" id="MenuName" name="MenuId[]" value="' . $menu['menuName'] . '" >
            <input type="hidden" id="MenuId" name="MenuId[]" value="' . $menu['MenuId'] . '" >
            <input type="hidden" id="MenuDetailId" name="MenuDetailId[]" value="' . $menu['MenuDetailId'] . '" >
            <input type="hidden" id="subMenuDetailId" name="subMenuDetailId[]" value="' . $menu['subMenuDetailId'] . '" >
        ';
    }

    public function generateCheckbox($action, $perSlug, $permissionListByRole = [])
    {
        $orgSlug = $perSlug . '-' . $action;
        $checked = in_array($orgSlug, $permissionListByRole) ? 'checked' : '';
        return '<input type="checkbox" name="' . $action . '_chk_' . $action . '[]" class="' . $action . '-row-checkbox form-check-input text-center" value="' . $orgSlug . '" ' . $checked . ' onclick="unselectAll(this,`' . $action . '-row-checkbox`,`' . $action . '-select-all-checkbox`)" />';
    }

    // public function isRead($items)
    // {
    //     if (Auth::check()) {
    //         $items->is_read = 1;
    //         $items->save();
    //     }
    // }

    // public function storeMessage($request)
    // {
    //     $user = Auth::user()->id;
    //     $request->merge(['user_id' => $user]);
    //     $request->merge(['ticket_id' => $request->ticket_id]);
    //     Message::create($request->except('_token', 'email'));
    // }

    // public function sentMail($item)
    // {
    //     // dd(!is_null($item->reply));

    //     if (!is_null($item->reply)) {
    //         //reply mail notification
    //         Mail::to($item->email)->send(new NewTicketMail($item));
    //     } else {
    //         //create mail notification
    //         Mail::to($item->email)->send(new NewTicketMail($item));
    //     }
    // }
}
