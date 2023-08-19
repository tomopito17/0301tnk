<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->group(function () {    
    Route::get('/', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'editAllocateUser']);
    Route::post('/edit/{id}', [App\Http\Controllers\UserController::class, 'UserEdit']);
});

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/delete', [App\Http\Controllers\ItemController::class, 'delete']);
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'editAllocate']);
    Route::post('/edit/{id}', [App\Http\Controllers\ItemController::class, 'ItemEdit']);
    Route::post('/upload', [App\Http\Controllers\ImageController::class, 'upload']);
    Route::post('/csv_upload', [App\Http\Controllers\ItemController::class, 'csv_upload']);
    Route::get('/csvfile_set', [App\Http\Controllers\ItemController::class, 'csvfile_set']);
    Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'detail']);
});

Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit']);
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update']);
