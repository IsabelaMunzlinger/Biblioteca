<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class UnoescController extends Controller
{
    /**
     * Index.
     */
    public function index(): View
    {
        return view('unoesc.index', [
            'response' => ''
        ]);
    }

    /**
     * Login.
     */
    public function login(Request $request): View
    {
        $response = Http::post('https://acad.unoesc.edu.br/academico/j_security_check', [
            'j_username' => $request->code,
            'j_password' => $request->password,
        ]);

        return view('unoesc.index', [
            'response' => $response
        ]);
    }
}
