<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function () {
    Route::get('/status', function (Request $request) {
        return response()->json([
            'status' => 'OK',
        ]);
    })->name('v1.status');

    Route::get('/user', function (Request $request) {
        return auth()->user();
    })->middleware('auth')->name('v1.user');

    Route::prefix('products')->namespace('Product')->group(static function () {
        Route::post('/', CreateProductController::class)->name('v1.product.create');
        Route::post('/{id}', UpdateProductController::class)->name('v1.product.update');
        Route::delete('/{id}', DeleteProductController::class)->name('v1.product.delete');

        Route::post(
            '/{product_id}/product-variants', 
            CreateProductVariantController::class
        )->name('v1.product-variant.create');

        Route::put(
            '/{product_id}/product-variants/{product_variant_id}/', 
            UpdateProductVariantController::class
        )->name('v1.product-variant.update');
    });

    Route::prefix('contacts')->namespace('Contact')->group(static function () {
        Route::get('/', GetContactsController::class)->name('v1.contact.index');
        Route::put('/', UpdateContactController::class)->name('v1.contact.update');
    });

    Route::prefix('blog')->namespace('Blog')->group(static function () {
        Route::post('/', CreateBlogController::class)->name('v1.blog.create');
        Route::post('/{id}', UpdateBlogController::class)->name('v1.blog.update');
        Route::delete('/{id}', BlogDeleteController::class)->name('v1.blog.delete');
    });

    Route::prefix('users')->group(static function () {
        Route::post('/{user_id}', UserProfileUpdateController::class)->name('v1.user.update');
        Route::delete('/{user_id}', User\UserDeactivateController::class)->name('v1.user.delete');
        Route::get('/', User\UserIndexController::class)->name('v1.user.index');
    });

    Route::prefix('teams')->group(static function () {
        Route::get('/', Team\TeamIndexController::class)->name('v1.teams.index');
        Route::put('/{team_id}', Team\UpdateTeamController::class)->name('v1.teams.update');
        Route::post('/', Team\CreateTeamController::class)->name('v1.teams.create');
        Route::post('/{team_id}/users', Team\AddUserToTeamController::class)->name('v1.teams.adduser');
        Route::delete('/{team_id}/users', Team\RemoveUserFromTeamController::class)->name('v1.teams.removeuser');
    });

    Route::prefix('tasks')->group(static function () {
        Route::post('/', Task\CreateTaskController::class)->name('v1.tasks.create');
        Route::get('/', Task\TaskIndexController::class)->name('v1.tasks.index');
        Route::put('/{task_id}', Task\TaskStateChangeController::class)->name('v1.tasks.update');
    });

    Route::prefix('admin')->group(static function () {
        Route::prefix('roles')->group(static function () {
            Route::get('/', Admin\Roles\GetRolesController::class)->name('v1.roles.index');
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
