<?php

namespace App\Repositories;

use App\Http\Requests\Shop\CheckoutRequest;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\ProductVariant;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartRepository
{
    public $cart;

    private $reserved = false;

    private $invoice = null;

    private $request = null;

    public function __construct()
    {
        $this->cart = Session::get('cart', []);
    }

    public function addToCart(ProductVariant $variant, int $quantity = 1): array
    {
        $item = [
            'id' => $variant->id,
            'quantity' => $quantity,
            'product' => $variant->product,
            'product_variant' => $variant
        ];
        $added = false;
        $newCart = [];
        foreach ($this->cart as $cartItem) {
            if ($cartItem['id'] === $variant->id) {
                $newTotal = $cartItem['quantity'] + $quantity;
                if ($newTotal > $variant->quantity) {
                    throw new Exception("No more items available");
                }
                $cartItem['quantity'] = $newTotal;
                $added = true;
            }
            array_push($newCart, $cartItem);
        }

        if (! $added) {
            if ($quantity > $variant->quantity) {
                throw new Exception("Item in short supply");
            }
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

    public function getSubTotal(): int
    {
        $total = 0;

        foreach ($this->cart as $item) {
            $price = ProductVariant::findOrFail($item['id'])->product->price;
            $total += $price * $item['quantity'];
        }

        return $total;
    }

    public function getTax(): int
    {
        return 0;
    }

    public function getDiscount(): int
    {
        return 0;
    }

    public function getGrandTotal(): int
    {
        return $this->getSubTotal() + $this->getTax();
    }

    public function checkout(CheckoutRequest $request)
    {
        $this->request = $request;
        if ($this->reserveCartItems()) {
            try {
                if ($request->user_id) {
                    $user = auth()->user();
                    $address = Address::findOrFail($request->address_id);
                } else {
                    $email = $request->get('email');
                    $fname = $request->get('first_name');
                    $fname = explode(' ', $fname);
                    $fname = strtolower(implode('', $fname));
                    if (! $email) {
                        $url = env('APP_URL');
                        $domain = explode('//', $url);
                        $domain = $domain[1];
    
                        $email = $fname.rand(100, 1000000).'@'.$domain;
                    }
                    $pass = Str::random(16);
    
                    $name = $request->get('first_name');
    
                    $username = strtolower(
                        preg_replace('/[^a-zA-Z0-9]+/', '', $name)
                    ).rand(1000, 9999);

                    $user = User::where('email', $email)
                        ->orWhere('phone_number', $request->phone_number)
                        ->first();

                    if (!$user) {
                        $user = User::create(
                            [
                                'name' => $request->get('first_name'),
                                'username' => $username,
                                'email' => $email,
                                'phone_number' => $request->get('phone_number'),
                                'password' => Hash::make($pass),
                            ]
                        );
                    }
    
                    
                    $address = Address::create(
                        [
                            'first_name' => $request->get('first_name'),
                            'user_id' => $user->id,
                        ]
                    );
    
                    $address->fill($request->validated());
                    $address->save();
                }
            } catch (Exception $e) {
                $this->releaseCartItems();
                throw $e;
            }
        } else {
            throw new Exception('Failed to reserve cart');
        }

        if ($this->makeInvoice($user, $address)) {
            $this->emptyCart();
            return [
                'invoice' => $this->invoice,
                'paid' => false,
            ];
        } else {
            $this->releaseCartItems();

            return false;
        }
    }

    private function makeInvoice(User $user, Address $address): bool
    {
        $invoice = Invoice::create(
            [
                'reference' => 'INVOICE'.rand(10000, 99999),
                'user_id' => $user->id,
                'cart' => $this->getCart(),
                'address_id' => $address->id,
                'sub_total' => $this->getSubTotal(),
                'tax' => $this->getTax(),
                'shipping_cost' => 0,
                'discount' => 0,
                'grand_total' => $this->getGrandTotal(),
                'payment_method_id' => $this->request->payment_method_id,
            ]
        );

        if ($invoice->id) {
            $this->invoice = $invoice;

            return true;
        } else {
            return false;
        }
    }

    private function reserveCartItems(): bool
    {
        $reserved = [];
        $canReserve = true;
        foreach ($this->cart as $item) {
            $variant = ProductVariant::find($item['id']);
            $quantity = $item['quantity'];
            $available = $variant->quantity;
            if ($available < $quantity) {
                $canReserve = false;
                break;
            } else {
                $variant->quantity -= $quantity;
                $variant->save();
                array_push($reserved, $item);
            }
        }

        if (! $canReserve) {
            foreach ($reserved as $item) {
                $variant = ProductVariant::find($item['id']);
                $variant->quantity += $item['quantity'];
                $variant->save();
            }

            return false;
        }

        $this->reserved = true;

        return true;
    }

    private function releaseCartItems(): bool
    {
        if (! $this->reserved) {
            return false;
        }
        foreach ($this->cart as $item) {
            $variant = ProductVariant::find($item['id']);
            $variant->quantity += $item['quantity'];
            $variant->save();
        }

        return true;
    }
}
