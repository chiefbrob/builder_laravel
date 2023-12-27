<?php
/**
 * Stateful routes for vue 2 frontend
 * 
 * @category Laravel_Routes
 * @package  Builder_Laravel
 * @author   Brian Chief Obare <brianobare@gmail.com>
 * @license  MIT https://github.com/chiefbrob/builder_laravel/blob/master/LICENSE
 * @link     https://builder-laravel.on.chiefbrob.info
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(
    static function () {
        Route::get(
            '/status', function (Request $request) {
                return response()->json(
                    ['status' => 'OK']
                );
            }
        )->name('v1.status');

        Route::get(
            '/user', function (Request $request) {
                return auth()->user();
            }
        )->middleware('auth')->name('v1.user');

        Route::prefix('shop/products')->namespace('Shop')->group(
            static function () {
                Route::get('/', 'ShopProductsIndexController')
                    ->name('v1.shop.products.index');
            }
        );

        Route::prefix('products')->namespace('Product')->group(
            static function () {
                Route::post('/', 'CreateProductController')
                    ->name('v1.product.create');
                Route::post('/{id}', 'UpdateProductController')
                    ->name('v1.product.update');
                Route::delete('/{id}', 'DeleteProductController')
                    ->name('v1.product.delete');

                Route::patch('/{product_id}', 'RestoreProductController')
                    ->name('v1.product.restore');

                Route::post(
                    '/{product_id}/product-variants', 
                    'CreateProductVariantController'
                )->name('v1.product-variant.create');

                Route::post(
                    '/{product_id}/product-variants/{product_variant_id}/', 
                    'UpdateProductVariantController'
                )->name('v1.product-variant.update');
            }
        );

        Route::prefix('contacts')->namespace('Contact')->group(
            static function () {
                Route::get('/', 'GetContactsController')->name('v1.contact.index');
                Route::put('/', 'UpdateContactController')
                    ->name('v1.contact.update');
            }
        );

        Route::prefix('blog')->namespace('Blog')->group(
            static function () {
                Route::post('/', 'CreateBlogController')->name('v1.blog.create');
                Route::post('/{id}', 'UpdateBlogController')->name('v1.blog.update');
                Route::delete('/{id}', 'BlogDeleteController')
                    ->name('v1.blog.delete');
            }
        );

        Route::prefix('users')->group(
            static function () {
                Route::post('/{user_id}', 'UserProfileUpdateController')
                    ->name('v1.user.update');
                Route::delete('/{user_id}', 'User\UserDeactivateController')
                    ->name('v1.user.delete');
                Route::get('/', 'User\UserIndexController')->name('v1.user.index');
            }
        );

        Route::prefix('teams')->namespace('Team')->group(
            static function () {
                Route::get('/', 'TeamIndexController')->name('v1.teams.index');
                Route::put('/{team_id}', 'UpdateTeamController')
                    ->name('v1.teams.update');
                Route::post('/', 'CreateTeamController')->name('v1.teams.create');
                Route::post('/{team_id}/users', 'AddUserToTeamController')
                    ->name('v1.teams.adduser');
                Route::delete('/{team_id}/users', 'RemoveUserFromTeamController')
                    ->name('v1.teams.removeuser');
            }
        );

        Route::prefix('tasks')->namespace('Task')->group(
            static function () {
                Route::post('/', 'CreateTaskController')->name('v1.tasks.create');
                Route::get('/', 'TaskIndexController')->name('v1.tasks.index');
                Route::put('/{task_id}', 'TaskStateChangeController')
                    ->name('v1.tasks.update');

                Route::prefix('task-templates')->group(
                    static function () {
                        Route::get(
                            '/', 'GetTaskTemplatesController'
                        )->name('v1.task-templates.index');
                        Route::post(
                            '/', 'CreateTaskTemplateController'
                        )->name('v1.task-template.create');
                    }
                );
                
                
            }
        );

        Route::prefix('admin')->namespace('Admin')->group(
            static function () {
                Route::prefix('roles')->namespace('Roles')->group(
                    static function () {
                        Route::get('/', 'GetRolesController')
                            ->name('v1.roles.index');
                        Route::post('/', 'CreateRoleController')
                            ->name('roles.create');
                    }
                );
                Route::prefix('users')->group(
                    static function () {
                        Route::get('/', 'AdminGetUsersController')
                            ->name('admin.users');
                        Route::delete('/', 'Users\AdminDeleteUserController')
                            ->name('admin.users.delete');
                    }
                );

                Route::prefix('user-roles')->namespace('Roles')->group(
                    static function () {
                        Route::post('/', 'AddUserRoleController')
                            ->name('user-role.create');
                        Route::delete('/', 'RemoveRoleController')
                            ->name('user-role.delete');
                    }
                );
            }
        );

        Route::prefix('invoices')->namespace('Invoices')->group(
            static function () {
                Route::get('/', 'InvoicesIndexController')
                    ->name('v1.invoices.index');
                Route::get('/{reference}', 'GetInvoiceController')
                    ->name('v1.invoices.single');
                Route::post(
                    '/{reference}/invoice-states', 
                    'CreateInvoiceStateChangeController'
                )->name('v1.invoices.createstate');
            }
        );

        Route::prefix('addresses')->namespace('Address')->group(
            static function () {
                Route::post('/', 'CreateAddressController')
                    ->name('v1.address.store');

                Route::get('/', 'GetAddressController')
                    ->name('v1.address.index');
                
                Route::put('/{address_id}', 'UpdateAddressController')
                    ->name('v1.address.update');

                Route::delete('/{address_id}', 'DeleteAddressController')
                    ->name('v1.address.delete');

            }
        );
    }
);
