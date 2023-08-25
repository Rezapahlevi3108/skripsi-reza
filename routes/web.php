<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KmeansController;

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

Route::get('register', [UserController::class, 'register'])->name('register')->middleware('guest');
Route::post('register', [UserController::class, 'register_action'])->name('register.action')->middleware('guest');
Route::get('/', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [UserController::class, 'login_action'])->name('login.action')->middleware('guest');
Route::get('password', [UserController::class, 'password'])->name('password')->middleware('auth');
Route::post('password', [UserController::class, 'password_action'])->name('password.action')->middleware('auth');
Route::get('logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/home',[MainController::class,'home'])->name('home')->middleware('auth');
Route::get('/data',[MainController::class,'data'])->name('data')->middleware('auth');
Route::post('/data-import',[MainController::class,'import'])->middleware('auth');
Route::get('/data-export',[MainController::class,'export'])->middleware('auth');
Route::post('/delete-data', [MainController::class, 'deleteData'])->name('delete-data')->middleware('auth');

Route::get('/option-cluster',[KmeansController::class,'optionCluster'])->name('option-cluster')->middleware('auth');
Route::post('/setCluster',[KmeansController::class,'setCluster'])->name('setCluster')->middleware('auth');
Route::get('/showKmeans', [KmeansController::class, 'showKmeans'])->name('showKmeans')->middleware('auth');
Route::post('/kmeans', [KmeansController::class, 'kmeans'])->name('kmeans')->middleware('auth');
Route::get('/dbi', [KmeansController::class, 'dbi'])->name('dbi')->middleware('auth');
Route::get('/perhitunganView', [KmeansController::class, 'perhitunganView'])->name('perhitunganView')->middleware('auth');
Route::post('/perhitungan', [KmeansController::class, 'perhitungan'])->name('perhitungan')->middleware('auth');
