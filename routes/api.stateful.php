<?php

use App\Http\Controllers\Admin\Users\AdminDeleteUserController;
use App\Http\Controllers\Admin\Roles\AddUserRoleController;
use App\Http\Controllers\Admin\AdminGetUsersController;
use App\Http\Controllers\Admin\Roles\CreateRoleController;
use App\Http\Controllers\Admin\Roles\RemoveRoleController;
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
        Route::prefix('users')->group(static function () {
            Route::get('/', AdminGetUsersController::class)->name('admin.users');
            Route::delete('/', AdminDeleteUserController::class)->name('admin.users.delete');
        });

        Route::prefix('user-roles')->group(static function () {
            Route::post('/', AddUserRoleController::class)->name('user-role.create');
            Route::delete('/', RemoveRoleController::class)->name('user-role.delete');
        });
    });
});