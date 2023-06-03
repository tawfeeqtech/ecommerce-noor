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
        /*$validatedData = $request->validate([
            'name' => 'required|min:4',
            'email' => 'nullable|email',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users,phone',
            'address' => 'nullable',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);*/


        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'nullable|email',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users,phone',
            'address' => 'nullable',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(),'errors', 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasfile('photo')) {
            /*$profilePicturePath = $request->file('photo')->store('profile_pictures');
            $validatedData['img'] = $profilePicturePath;*/

            $uploadPath = 'uploads/profile_pictures/';

            /*$file = $request->file('photo');

            $filename = time() . '.' . $file->extension();


            $file->move(public_path($uploadPath), $filename);

            $finalImagePathName = $uploadPath . $filename;*/

            $validatedData['img'] = $this->uploadImage($uploadPath,$request);
        }

        $validatedData['role_as'] = 2;
        $validatedData['password'] = bcrypt($validatedData['password']);
        /*$user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role_as' => 2,
            'password' => bcrypt($request->password)
        ]);*/
        $user = User::create($validatedData);

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
            /*$success['name'] =  $user->name;
            $success['address'] =  $user->address;
            $success['phone'] =  $user->phone;
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;*/
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return $this->apiResponse($success, "تم تسجيل الدخول بنجاح", 200);
        } else {
            return $this->apiResponse(null, "غير مصرح", 401);
        }
    }


}
