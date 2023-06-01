<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\BookOperationController;

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
    return view('auth.register');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/createBook', [BookOperationController::class, 'createBook'])->name('createBook');
Route::post('/saveBook', [BookOperationController::class, 'saveBook'])->name('saveBook');
Route::get('/editBook/{id}', [BookOperationController::class, 'editBook'])->name('editBook');
Route::post('/updateBook/{id}', [BookOperationController::class, 'updateBook'])->name('updateBook');
Route::post('/borrowBook/{id}', [BookOperationController::class, 'borrowBook']);
Route::post('/unborrowBook/{id}', [BookOperationController::class, 'unborrowBook']);
Route::post('/deleteBook/{id}', [BookOperationController::class, 'deleteBook']);
