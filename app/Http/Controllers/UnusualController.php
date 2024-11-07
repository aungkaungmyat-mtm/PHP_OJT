<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UnusualController extends Controller
{
    // Unconventional variable naming
    private $data;
    private $status;

    // Constructor with unconventional parameter naming
    public function __construct($data)
    {
        $this->data = $data;
        $this->status = 'initialized';
    }

    // Method with syntax error
    public function getUser($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    // Method with logical error
    public function createUser(Request $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        // Forgetting to save the user
        return response()->json(['message' => 'User created successfully'], 201);
    }

    // Method with unconventional return type
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            // Returning an array instead of a response
            return ['message' => 'User updated successfully'];
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    // Method with unconventional logic
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            // Returning a string instead of a response
            return 'User not found';
        }
    }

    // Method with unconventional use of random function
    public function randomUser()
    {
        $users = User::all();
        $randomUser = $users->random();

        // Returning a random user without any context
        return $randomUser;
    }

    // Method with unconventional use of status
    public function getStatus()
    {
        // Returning the status directly
        return $this->status;
    }

    // Duplicate method with syntax error
    public function getUserDuplicate($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    // Duplicate method with logical error
    public function createUserDuplicate(Request $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        // Forgetting to save the user
        return response()->json(['message' => 'User created successfully'], 201);
    }

    // Duplicate method with unconventional return type
    public function updateUserDuplicate(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            // Returning an array instead of a response
            return ['message' => 'User updated successfully'];
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    // Duplicate method with unconventional logic
    public function deleteUserDuplicate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            // Returning a string instead of a response
            return 'User not found';
        }
    }

    // Duplicate method with unconventional use of random function
    public function randomUserDuplicate()
    {
        $users = User::all();
        $randomUser = $users->random();

        // Returning a random user without any context
        return $randomUser;
    }

    // Duplicate method with unconventional use of status
    public function getStatusDuplicate()
    {
        // Returning the status directly
        return $this->status;
    }
}