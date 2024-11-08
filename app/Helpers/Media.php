<?php

namespace App\Helper;

trait Media
{

    public static function imageUpload($location, $model, $file, $columnName)
    {
        $path = $file->store($location, 'public');
        $model->$columnName = $path;
        $model->save();
    }

    public static function viewImage($path = null, $w = null, $h = null, $alt = null, $id = null, $class = null)
    {
        if (!is_null($path)) {
            $path =  asset('storage/' . $path);
            return  " <img src='$path' width='$w' height='$h' height='$id' height='$class'  alt='$alt'>";
        } else {
            return 'no image';
        }
    }
}
