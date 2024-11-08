<?php

namespace App\Repositories\Administration;

use App\Models\User;
use App\Models\Menu\MenuHeader;
use Spatie\Permission\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepo extends BaseRepository
{
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function createRole($request)
    {
        try {
            $created = $this->model->create(['name' => $request->name]);

            if ($created) {
                if ($request->has('assignedTo')) {
                    foreach ($request->assignedTo as $key => $userId) {
                        $user = User::find($userId);
                        $user->assignRole($request->name);
                    }
                }
                return $created;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
