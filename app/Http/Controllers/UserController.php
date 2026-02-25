<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Index.
     */
    public function index(): View
    {
        return view('users', [
            'users' => User::all()
        ]);
    }
}
