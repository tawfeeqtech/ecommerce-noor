<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $message = null, $status = null)
    {
        $array = [
            'data' => $data,
            'message' => $message,
            'status' => $status
        ];
        return response($array,$status);
    }

    public function uploadImage($uploadPath,$request)
    {
        $file = $request->file('photo');
        $filename = time() . '.' . $file->extension();
        $file->move(public_path($uploadPath), $filename);

        return $uploadPath . $filename;
    }
}
