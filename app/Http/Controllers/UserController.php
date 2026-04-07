<?php

namespace App\Http\Controllers;

use App\Models\Phone;
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
        $user->load('phones');

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
        if ($user->phones()->exists()) {
            return back()
                ->withErrors(['Não é possível excluir um user com phone vinculado']);
        }

        $user->delete();
 
        return redirect('/users');
    }

    /**
     * Create phone.
     */
    public function createPhone(Request $request, User $user): View
    {
        return view('users.phones.create', [
            'user' => $user
        ]);
    }

    /**
     * Store phone.
     */
    public function storePhone(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'number' => 'required|size:11|unique:phones,number',
        ], [
            'number.required' => 'O campo número é obrigatório',
            'number.size' => 'O número deve ter 11 dígitos (DDD + 9)',
            'number.unique' => 'O número informado já existe',
        ]);

        $user->phones()->create([
            'number' => $request->number
        ]);

        return redirect("/users/{$user->id}");
    }

    /**
     * Delete phone.
     */
    public function deletePhone(Request $request, User $user, Phone $phone): RedirectResponse
    { 
        $phone->delete();
 
        return back();
    }
}
