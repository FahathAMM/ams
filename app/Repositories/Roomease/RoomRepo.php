<?php

namespace App\Repositories\Roomease;

use App\Models\Roomease\Apartment;
use App\Models\Roomease\Room;
use App\Repositories\BaseRepository;

class RoomRepo extends BaseRepository
{
    protected $model;

    public function __construct(Room $model)
    {
        $this->model = $model;
    }

    public function createRoom($request)
    {
        try {
            $created = $this->model->create($request->validated());

            if ($created) {
                return $created;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateRoom($request, $model)
    {
        try {
            $updated = $model->update($request->validated());

            if ($updated) {
                return $updated;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
