<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PassportAuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Registration
     * @param Request $request
     * @return ResponseFactory|Response
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'nullable|email',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users,phone',
            'address' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(),'errors', 422);
        }

        $validatedData = $validator->safe()->only(['name', 'email','password','phone']);
        $validatedDetailData = $validator->safe()->only(['address']);

        if ($request->hasfile('photo')) {
            $uploadPath = 'uploads/profile_pictures/';
            $validatedDetailData['img'] = $this->uploadImage($uploadPath,$request);
        }

        $validatedData['password'] = bcrypt($validatedData['password']);


        $user = User::create($validatedData);

        $user->userDetail()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'pin_code'=>'pin_code',
                'address'=>$validatedDetailData['address'],
                'img'=>$validatedDetailData['img'],
            ]
        );

        $user['token'] = $user->createToken('LaravelAuthApp')->accessToken;
        return $this->apiResponse($user, "بيانات المستخدم", 201);
    }

    /**
     * Login
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $data = [
            'phone' => $validatedData['phone'],
            'password' => $validatedData['password']
        ];
        if (auth()->attempt($data)) {
            $user = Auth::user();
            $success['id'] = $user->id;
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return $this->apiResponse($success, "تم تسجيل الدخول بنجاح", 200);
        } else {
            return $this->apiResponse(null, "غير مصرح", 401);
        }
    }


}
