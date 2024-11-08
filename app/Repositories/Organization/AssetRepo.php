<?php

namespace App\Repositories\Organization;

use App\Models\Asset\Asset;
use App\Repositories\BaseRepository;

class AssetRepo extends BaseRepository
{
    protected $model;

    public function __construct(Asset $model)
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

    public function createAsset($request)
    {
        $attrValues = $request->value;
        $attr =  $request->attribute;

        $created = $this->model->create($request->validated());
        if ($created) {

            foreach ($attrValues as $key => $valData) {
                $created->attributes()->attach($attr[$key], ['value' => $valData]);
            }

            if ($request->hasFile('img')) {
                $this->model->imageUpload('/asset', $created, $request->file('img'), 'img');
            }

            return $created;
        }
        return false;
    }

    public function updateAsset($request, $model)
    {
        $attrValues = $request->value;
        $attr = $request->attribute;

        $updated = $model->update($request->validated());
        if ($updated) {

            foreach ($attrValues as $key => $valData) {
                $model->attributes()->detach($attr[$key], ['value' => $valData]);
                $model->attributes()->attach($attr[$key], ['value' => $valData]);
            }

            if ($request->hasFile('img')) {
                $this->model->imageUpload('/asset', $model, $request->file('img'), 'img');
            }

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
