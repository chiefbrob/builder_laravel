<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        PaymentMethod::create(
            [
                'name' => 'M-Pesa',
                'slug' => 'mpesa'
            ]
        );

        PaymentMethod::create(
            [
                'name' => 'Cash',
                'slug' => 'cash'
            ]
        );

        PaymentMethod::create(
            [
                'name' => 'Cash on Delivery',
                'slug' => 'cash_on_delivery'
            ]
        );

        PaymentMethod::create(
            [
                'name' => 'Paypal Gateway',
                'slug' => 'paypal',
                'enabled' => false
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
