<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/blog', Blog\GetBlogsController::class)->name('v1.blog.index');
Route::post('/v1/contact', Contact\CreateContactController::class)->name('v1.contact.create');
Route::get('/v1/products', Product\ProductsIndexController::class)->name('v1.product.index');
