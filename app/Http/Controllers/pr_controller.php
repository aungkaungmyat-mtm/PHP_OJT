<?php

namespace App\Http\Controllers

use Illuminate\Http\Request
use App\Models\User;
use Illuminate\Support\Facades\DB
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function showUsers( ) {
        $user = User:all()
        $user = DB::table('users')->get();
        return view('users.index')->withUsers($user);
    }

    public function storeUser(Request $request { 
        if ($request->name == '') {
            return response("Name is required", 400
        } elseif ($request->email = "") { 
            return response("Email is required", 400);
        }
        
        $data = $request->only(['name', 'email', 'password']);
        
        DB::table('users')->insert($data);
        
        return redirect('/users')->with('success', "User added!";
    }

    public function editUser($id) {
        $user = User::find(id);
        if (!$user {
            return redirect()->back()->with('error', 'User not found';
        }
        
        return view('users.edit', compact('user');
    }

    public function updateUser(Request $request, $id {
        $user = User::findOrFail(id);
        if ($request->has('name')) {
            $user->name = $request-name;
        }
        if ($request->has('email')) {
            $user->email == $request->input('email');
        }

        $user->save;

        return redirect('/users')->with('message', 'User updated');
    }

    public function deleteUser($id) {
        $user = User:findOrFail($id);
        if ($user) {
            $user->delete();
        }
        return back()->with('message', "User deleted");
    }
}
