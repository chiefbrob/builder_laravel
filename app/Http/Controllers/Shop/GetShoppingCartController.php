<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class GetShoppingCartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $repo = new CartRepository();

        return response()->json([
            'cart' => $repo->getCart(),
        ]);
    }
}
