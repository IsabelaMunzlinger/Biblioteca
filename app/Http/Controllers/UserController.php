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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ], [
            'name.required' => 'O campo nome é obrigatório',
            'email.unique' => 'Já existe um user com este e-mail',
        ]);
 
        $user = new User;
 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
 
        $user->save();
 
        return redirect('/users');
    }

    /**
     * Edit.
     */
    public function edit(Request $request, User $user): View
    { 
        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'O campo nome é obrigatório',
            'email.unique' => 'Já existe um user com este e-mail',
        ]);
 
        $user->name = $request->name;
        $user->email = $request->email;
 
        $user->save();
 
        return redirect('/users');
    }

    /**
     * Cofirm delete.
     */
    public function confirmDelete(Request $request, User $user): View
    { 
        return view('users.delete', [
            'user' => $user
        ]);
    }

    /**
     * Delete.
     */
    public function delete(Request $request, User $user): RedirectResponse
    { 
        $user->delete();
 
        return redirect('/users');
    }
}
