<?php

use App\Http\Controllers\UnoescController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LivrosController;
use App\Http\Controllers\LeitorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Rota para a página inicial
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/livros/{livro}', [LivrosController::class, 'show'])->name('livros.show');

//Rotas para os livros
Route::get('/livros', [LivrosController::class, 'index']);
Route::get('/livros/create', [LivrosController::class, 'create'])->name('livros.create');
Route::post('/livros/store', [LivrosController::class, 'store'])->name('livros.store');


//Rotas para os leitores
Route::get('/leitores/create', [LeitorController::class, 'create'])->name('leitores.create');
Route::post('/leitores/store', [LeitorController::class, 'store'])->name('leitores.store');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users/store', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'edit']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::get('/users/{user}/delete', [UserController::class, 'confirmDelete']);
Route::delete('/users/{user}', [UserController::class, 'delete']);

Route::get('/users/{user}/phone', [UserController::class, 'createPhone']);
Route::post('/users/{user}/phone', [UserController::class, 'storePhone']);
Route::delete('/users/{user}/phone/{phone}', [UserController::class, 'deletePhone']);

Route::get('/unoesc', [UnoescController::class, 'index']);
Route::post('/unoesc', [UnoescController::class, 'login']);