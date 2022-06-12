<?php

use App\Models\InvoiceState;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('cart');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->integer('sub_total')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('shipping_cost')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('grand_total')->default(0);
            $table->string('status')->default(InvoiceState::STATUS_PENDING);
            $table->unsignedBigInteger('payment_method_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
