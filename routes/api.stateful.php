<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::get('/status', function (Request $request) {
        return response()->json([
            'status' => 'OK'
        ]);
    })->name('v1.status');

    Route::prefix('users')->group(static function () {
        Route::post('/{user_id}', UserProfileUpdateController::class)->name('v1.user.update');
        Route::delete('/{user_id}', User\UserDeactivateController::class)->name('v1.user.delete');
    });

    Route::prefix('admin')->group(static function () {
        Route::prefix('roles')->group(static function () {
            Route::post('/', Admin\Roles\CreateRoleController::class)->name('roles.create');
        });
        Route::prefix('users')->group(static function () {
            Route::get('/', Admin\AdminGetUsersController::class)->name('admin.users');
            Route::delete('/', Admin\Users\AdminDeleteUserController::class)->name('admin.users.delete');
        });

        Route::prefix('user-roles')->group(static function () {
            Route::post('/', Admin\Roles\AddUserRoleController::class)->name('user-role.create');
            Route::delete('/', Admin\Roles\RemoveRoleController::class)->name('user-role.delete');
        });
    });
});