<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $pageName = 'user';

    public function index()
    {
        $entities = User::paginate(10);
        return view('admin.users.index', [
            'entities' => $entities,
            'pageName' => $this->pageName
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'pageName' => $this->pageName
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role_as' => ['required', 'integer'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_as' => $validated['role_as'],
        ]);

        return to_route('users.index')->with('message','User Created Successfully');
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('admin.users.edit',[
            'entity' => $user,
            'pageName' => $this->pageName,
        ]);
    }

    public function update(Request $request, $user_id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'role_as' => ['required', 'integer'],
        ]);

        User::findOrFail($user_id)->update([
            'name' => $validated['name'],
            'email' => $request->email,
            'password' => Hash::make($validated['password']),
            'role_as' => $validated['role_as'],
        ]);

        return to_route('users.index')->with('message','User Update Successfully');
    }

    public function destroy($user_id)
    {
        User::findOrFail($user_id)->delete();
        return to_route('users.index')->with('message','User Deleted Successfully');
    }
}
