<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request): Response {
        

        return Inertia::render('User/UserList', [
            
        ]);
    }
}
