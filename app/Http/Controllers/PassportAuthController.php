<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PassportAuthController extends Controller
{
    /**
     * Registration
     * @param Request $request
     * @return JsonResponse
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
        return response()->json($user, 200);
    }

    /**
     * Login
     * @param Request $request
     * @return JsonResponse
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
            return response()->json($success, 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
