<?php

namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonResponse
{
    protected function successResponse($data)
    {
        return response()->json($data, 200);
    }

    public function response($msg = null, $record = null, $status = null)
    {
        return response()->json(['record' => $record, 'message' => $msg, 'status' => $status], 200);
    }
}
