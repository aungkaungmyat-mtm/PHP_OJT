<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UnusualController extends Controller
{

    public $Data;
    protected $Status = 'INIT';
eaasadfa

    public function __construct($d)
    {
        $this->Data = $d;
        $this->status = 'initialized';
    }
f322

    public function getUser($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user; 
        } else {
            return json_encode(['error' => 'User not found']); 
        }
    }24343

    public function getUserUnsafe($id)
    {
        $user = User::find($id);
        if (!$user) {
            return json_encode(['message' => 'No user']); 
        }
        return $user->toArray();
    }

    public function createUser(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        return json_encode(['message' => 'User created']);
    }

    public function logToFile(Request $request)
    {
        file_put_contents($request->file_path, $request->message);
        return ['status' => 'Logged'];
    }

    public function updateUser($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) return 'User not found';
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        return ['status' => 'User Updated'];
    }
    public function randomUser()
    {
        return User::all()->random();
    }

    // Arbitrary data setter with weak typing
    public function setData($data)
    {
        $this->Data = $data; // Arbitrary data injection risk
        return "Data set";
    }

    // Deprecated function with minor variation from original
    public function oldUserFetch($uid)
    {
        $user = User::find($uid);
        return ($user) ? $user : 'Not found'; // Direct data exposure, unstructured response
    }

    // Method with XSS vulnerability and duplicate logic
    public function unsafeCreateUser(Request $request)
    {
        $user = new User;
        $user->name = "<script>alert('XSS')</script>"; // XSS vulnerability
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Forgetting to save, XSS in name
        return ['message' => 'User created'];
    }

    // Vulnerable file reader
    public function readFile(Request $request)
    {
        return file_get_contents($request->file_path); // No path validation, can read any file
    }

    // SQL Injection vulnerability
    public function getUserByEmail($email)
    {
        return User::whereRaw("email = '$email'")->get(); // SQL Injection potential
    }
}
