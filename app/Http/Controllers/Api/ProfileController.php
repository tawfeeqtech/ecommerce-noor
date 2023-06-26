<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    use ApiResponseTrait;

    public function show()
    {
        $user = Auth::user();

        $profile_data =[
          'name' =>  $user->name,
            'phone' =>  $user->phone,
            'address' =>  $user->userDetail->address,
        ];
        if(isset($user->userDetail->img) && $user->userDetail->img != null){
            $profile_data["photo"] =  $user->userDetail->img;
        }
        return $this->apiResponse($profile_data, "بيانات الملف الشخصي", 200);
    }

    public function update(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'address' => 'sometimes|required',
            'phone' => 'sometimes|required|unique:users,phone,' . $user->id,
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(),'errors', 422);
        }
        $validated = $validator->safe()->except(['address', 'photo']);
        $validatedDetailData = $validator->safe()->only(['address']);
        if ($request->hasFile('photo')) {
            $uploadPath = 'uploads/profile_pictures/';

            $validatedDetailData['img'] = $this->uploadImage($uploadPath,$request);

            // Delete the old profile picture if exists
            $imagePath = $user->userDetail->img;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        if($validated ){
            $user->update($validated);
            $user->userDetail()->updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'pin_code'=>'pin_code',
                    'address'=> isset($validatedDetailData['address']) ? $validatedDetailData['address']: $user->userDetail->address,
                    'img'=>$validatedDetailData['img'],
                ]
            );
            return $this->apiResponse([], 'updated successfully', 200);
        }
        return $this->apiResponse([],'errors', 400);
    }

    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        return response()->json(null, 204);
    }


    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user()->token();
            $user->revoke();
            return $this->apiResponse(null, "تم تسجيل الخروج بنجاح", 200);
        } else {
            return $this->apiResponse(null, "يجب تسجيل الدخول", 200);
        }
    }
}
