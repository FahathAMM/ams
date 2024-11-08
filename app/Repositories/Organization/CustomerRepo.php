<?php

namespace App\Repositories\Organization;

use App\Models\Customer\Customer;
use App\Repositories\BaseRepository;

class CustomerRepo extends BaseRepository
{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function __call($method, $parameters)
    {
        // Forward calls to the model instance
        $isExisit = $this->model->$method(...$parameters);

        if ($isExisit) {
            return $isExisit;
        }

        throw new \BadMethodCallException("Method {$method} does not exist on the model.");
    }

    public function createCustomer($request)
    {
        $created = $this->model->create($request->validated());
        if ($created) {
            return $created;
        }
        return false;
    }

    public function updateCustomer($request, $model)
    {
        $updated = $model->update($request->validated());
        if ($updated) {
            return $updated;
        }
        return false;
    }

    public function getAccessPermission(): array
    {
        return [
            'isView' => false,
            'isEdit' => true,
            'isDelete' =>  false,
            'isPrint' => false
        ];
    }
}
