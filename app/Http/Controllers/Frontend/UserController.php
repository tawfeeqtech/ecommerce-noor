<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.users.profile');
    }

    public function updateUserDetails(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required','string'],
            'phone' => ['required','digits:10'],
            'pin_code' => ['required','digits:6'],
            'address' => ['required','string','max:499'],
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'name' => $validated['username']
        ]);

        $user->userDetail()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'phone'=>$validated['phone'],
                'pin_code'=>$validated['pin_code'],
                'address'=>$validated['address'],
            ]
        );
        return redirect()->back()->with('message','User Profile Updated');
    }

    public function createPassword()
    {
        return view('frontend.users.change-password');
    }

    public function changePassword(Request $request)
    {
        $validate =  $request->validate([
            'current_password' => ['required','string','min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
        $currentPasswordStatus = Hash::check($validate['current_password'], auth()->user()->password);
        if($currentPasswordStatus){
            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($validate['password']),
            ]);
            return redirect()->back()->with('message','Password Updated Successfully');
        }else{
            return redirect()->back()->with('message','Current Password does not match with Old Password');
        }
    }
}
