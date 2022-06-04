<?php

namespace App\Repositories;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartRepository
{
    public $cart;

    public function __construct()
    {
        $this->cart = Session::get('cart', []);
    }
    

    public function addToCart(ProductVariant $variant, int $quantity = 1): array
    {
        
        $item = [
            'id' => $variant->id,
            'quantity' => $quantity,
        ];
        $added = false;
        $newCart = [];
        foreach ($this->cart as $cartItem) {
            if ($cartItem['id'] === $variant->id) {
                $newTotal = $cartItem['quantity'] + $quantity;
                $cartItem['quantity'] = $newTotal;
                $added = true;
            }
            array_push($newCart, $cartItem);
        }

        if (!$added) {
            array_push($newCart, $item);
        }
        $this->cart = $newCart;
        Session::put('cart', $newCart);
        return $this->getCart();
    }

    public function getCart(): array
    {
        return $this->cart;
    }

    public function removeFromCart(ProductVariant $variant, int $quantity = 1): array
    {
        $newCart = [];
        foreach ($this->cart as $cartItem) {
            
            if ($cartItem['id'] === $variant->id) {
                $newQuantity = $cartItem['quantity'] - $quantity;
                if ($newQuantity > 0) {
                    $cartItem['quantity'] = $newQuantity;
                    array_push($newCart, $cartItem);
                }
            } else {
                array_push($newCart, $cartItem);
            }
            
        }
        
        $this->cart = $newCart;
        Session::put('cart', $newCart);
        return $this->getCart();
    }

    public function emptyCart(): array
    {
        $this->cart = [];
        Session::put('cart', $this->cart);
        return $this->getCart();
    }

}