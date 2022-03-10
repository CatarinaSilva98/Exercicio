<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MensagemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::POST('/home/pub', [MensagemController::class, 'store'])->name('mensagem.store');
Route::delete('/home/{id}', [MensagemController::class, 'destroy'])->name('mensagem.destroy'); // making a delete request

Route::get('/home/up/{id}', [MensagemController::class, 'up'])->name('mensagem.up');
Route::get('/home/down/{id}', [MensagemController::class, 'down'])->name('mensagem.down');

