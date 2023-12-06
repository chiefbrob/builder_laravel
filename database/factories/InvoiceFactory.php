<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\InvoiceState;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Repositories\CartRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        $discount = rand(500, 1000);

        $product1 = Product::factory()->create(
            [
                'price' => rand(1000, 5000),
            ]
        );
        $variant1 = ProductVariant::create(
            [
                'product_id' => $product1->id,
                'name' => 'Variant '.$product1->name,
                'quantity' => rand(5, 20),
            ]
        );
        $product2 = Product::factory()->create(
            [
                'price' => rand(4000, 16000),
            ]
        );
        $variant2 = ProductVariant::create(
            [
                'product_id' => $product2->id,
                'name' => 'Variant '.$product2->name,
                'quantity' => rand(1, 4),
            ]
        );

        $repo = new CartRepository();
        $cart = $repo->addToCart($variant1, rand(1, 4));

        return [
            'reference' => 'SHOP'.rand(10000, 1000000),
            'user_id' => $user->id,
            'cart' => $cart,
            'address_id' => $address->id,
            'sub_total' => $repo->getSubTotal(),
            'tax' => $repo->getTax(),
            'shipping_cost' => 200,
            'discount' => $discount,
            'grand_total' => $repo->getGrandTotal(),
            'status' => InvoiceState::STATUS_PENDING,
            'payment_method_id' => PaymentMethod::first()->id,
        ];
    }
}
