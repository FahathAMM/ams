<?php

namespace App\Repositories;

use App\helpers\Media;
use App\Models\Category\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Repositories\BaseInterface\BaseRepositoryInterface;

class BaseRepository  implements BaseRepositoryInterface
{
    public function __construct()
    {
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail();
    }

    public function search($q, $page = null)
    {
        $items = $this->model->query();

        if (!is_null($q)) {
            $items->where('name', 'Like', '%' . $q . '%');
        }

        if (!is_null($page)) {
            return $items->paginate($page)->withQueryString();
        } else {
            return $items->get();
        }
    }

    public function create($collection)
    {
        return  $this->model->create($collection);
    }

    public function createWithAlertMessage($collection = [], $alertMessage = [], $extraAttributes = [])
    {
        // dd(array_merge($collection,$extraAttributes));
        // dd($collection);
        // dd($extraAttributes);

        $allData = array_merge($collection, $extraAttributes);

        if ($alertMessage != []) {
            request()->session()->flash($alertMessage[0], $alertMessage[1]);
        }
        return $this->model->create($allData);
    }
}
