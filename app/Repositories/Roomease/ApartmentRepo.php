<?php

namespace App\Repositories\Roomease;

use App\Models\Roomease\Apartment;
use App\Repositories\BaseRepository;

class ApartmentRepo extends BaseRepository
{
    protected $model;

    public function __construct(Apartment $model)
    {
        $this->model = $model;
    }

    public function createApartment($request)
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

    public function updateApartment($request, $apartment)
    {
        try {
            $updated = $apartment->update($request->validated());

            if ($updated) {
                return $updated;
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
