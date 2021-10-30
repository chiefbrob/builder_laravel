<?php

use App\Http\Controllers\AddUserRoleController;
use App\Http\Controllers\CreateRoleController;
use App\Http\Controllers\RemoveRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::get('/status', function (Request $request) {
        return response()->json([
            'status' => 'OK'
        ]);
    })->name('v1.status');

    Route::prefix('admin')->group(static function () {
        Route::prefix('roles')->group(static function () {
            Route::post('/', CreateRoleController::class)->name('roles.create');
        });

        Route::prefix('user-roles')->group(static function () {
            Route::post('/', AddUserRoleController::class)->name('user-role.create');
            Route::delete('/', RemoveRoleController::class)->name('user-role.delete');
        });
    });
});