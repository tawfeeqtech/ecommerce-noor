<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
