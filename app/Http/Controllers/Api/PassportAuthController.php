<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Contracts\Routing\ResponseFactory;
//use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role_as' => 2,
            'password' => bcrypt($request->password)
        ]);

//        $token =
        $user['token'] = $user->createToken('LaravelAuthApp')->accessToken;
        return $this->apiResponse($user, "بيانات المستخدم", 200);

//        return response()->json($user, 200);
    }

    /**
     * Login
     * @param Request $request
     * @return ResponseFactory|Response
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $user = Auth::user();
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['address'] =  $user->address;
            $success['phone'] =  $user->phone;
            $success['token'] =  $user->createToken('MyApp')->accessToken;

//            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return $this->apiResponse($success, "تم تسجيل الدخول بنجاح", 200);

//            return response()->json($success, 200);
        } else {
            return $this->apiResponse(null, "غير مصرح", 200);

//            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout()
    {
        if (Auth::check()) {

            $user = Auth::user()->token();
//            $tokens =  $user->tokens;


//            dd($tokens);

            $user->revoke();
            return $this->apiResponse(null, "تم تسجيل الخروج بنجاح", 200);

//            return response()->json('logged out', 200);
        }
        else{
            return $this->apiResponse(null, "يجب تسجيل الدخول", 200);

        }
    }
}
