<?php

use App\Http\Controllers\UnoescController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LivrosController;
use App\Http\Controllers\LeitorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmprestimoController;
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

//Rotas para os livros
Route::get('/livros', [LivrosController::class, 'index'])->name('livros.index');
Route::get('/livros/create', [LivrosController::class, 'create'])->name('livros.create');
Route::post('/livros/store', [LivrosController::class, 'store'])->name('livros.store');
Route::get('/livros/{livro}', [LivrosController::class, 'show'])->name('livros.show');
Route::get('/livros/{livro}/edit', [LivrosController::class, 'edit'])->name('livros.edit');
Route::put('/livros/{livro}', [LivrosController::class, 'update'])->name('livros.update');
Route::delete('/livros/{livro}', [LivrosController::class, 'destroy'])->name('livros.destroy');
Route::patch('/livros/{livro}/toggle-status', [LivrosController::class, 'toggleStatus'])->name('livros.toggleStatus');


//Rotas para os leitores
Route::get('/leitores', [LeitorController::class, 'index'])->name('leitores.index');
Route::get('/leitores/create', [LeitorController::class, 'create'])->name('leitores.create');
Route::post('/leitores/store', [LeitorController::class, 'store'])->name('leitores.store');
Route::get('/leitores/{leitor}', [LeitorController::class, 'show'])->name('leitores.show');
Route::get('/leitores/{leitor}/edit', [LeitorController::class, 'edit'])->name('leitores.edit');
Route::put('/leitores/{leitor}', [LeitorController::class, 'update'])->name('leitores.update');
Route::delete('/leitores/{leitor}', [LeitorController::class, 'destroy'])->name('leitores.destroy');



// Rotas de Empréstimos
Route::get('/emprestimos', [EmprestimoController::class, 'index'])->name('emprestimos.index');
Route::get('/emprestimos/create', [EmprestimoController::class, 'create'])->name('emprestimos.create');
Route::post('/emprestimos', [EmprestimoController::class, 'store'])->name('emprestimos.store');
Route::put('/emprestimos/{emprestimo}/devolver', [EmprestimoController::class, 'devolver'])->name('emprestimos.devolver');