<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
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


Auth::routes(['verify' => true]);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/test-mail', function (Request $request) {
    $email = $request->email ?? 'brianobare@gmail.com';
    return Mail::to($email)->send(new TestMail());
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

Route::get('/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*')->middleware('verified')->name('home');
