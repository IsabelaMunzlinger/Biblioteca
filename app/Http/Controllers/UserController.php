<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Index.
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Create.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store.
     */
    public function store(Request $request): RedirectResponse
    { 
        // Validar informações (email, senha, etc.)
 
        $user = new User;
 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
 
        $user->save();
 
        return redirect('/users');
    }
}
