<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

Route::prefix('v1')->group(static function () {
    Route::get('/cart', Shop\GetShoppingCartController::class)->name('v1.cart');
    Route::post('/cart', Shop\AddItemToCartController::class)->name('v1.cart.add');
    Route::delete('/cart', Shop\RemoveItemFromCartController::class)->name('v1.cart.delete');
    Route::delete('/cart/empty', Shop\EmptyCartController::class)->name('v1.cart.empty');
    Route::post('/checkout', Shop\CheckoutController::class)->name('v1.checkout');
    Route::get('/blog', Blog\GetBlogsController::class)->name('v1.blog.index');
    Route::middleware('throttle:10,1')
        ->post('/contact', Contact\CreateContactController::class)
        ->name('v1.contact.create');
    Route::get('/products', Product\ProductsIndexController::class)->name('v1.product.index');
    Route::post('/search', Search\SearchController::class)->name('v1.search');
});

Route::prefix('v2')->group(static function () {
    Route::middleware('throttle:20,1')->get('/', function (Request $request) {
        return response()->json(['message' => 'Status Ok',], Response::HTTP_OK);
    })->name('v2.status');

    Route::middleware('throttle:6,1')->group(
        static function () {
            Route::post(
                '/login', 
                v2\Auth\V2LoginController::class
            )->name('v2.login');

            Route::post(
                '/register', 
                v2\Auth\V2RegisterController::class
            )->name('v2.register');
        }
    );

    Route::prefix('shop')->group(
        static function () {
            Route::post('/checkout', v2\Shop\V2CheckoutController::class)
                ->name('v2.checkout');
        }
    );

    

    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('user')->group(
            static function () {
                Route::get('/', function (Request $request) {
                    return auth()->user();
                })->name('v2.user');
                Route::put('/', v2\User\V2UserProfileUpdateController::class)
                    ->name('v2.user.update');
            }
        );
        
        Route::post('/logout', v2\Auth\V2LogoutController::class)->name('v2.logout');

        Route::prefix('contacts')->group(static function () {
            Route::get('/', v2\Contact\V2GetContactsController::class)
                ->name('v2.contact.index');
        });
    });
});