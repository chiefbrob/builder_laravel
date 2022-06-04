<?php

use App\Models\ProductSize;
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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        ProductSize::create(['name' => 'Extra Small', 'slug' => 'XS']);
        ProductSize::create(['name' => 'Small', 'slug' => 'S']);
        ProductSize::create(['name' => 'Medium', 'slug' => 'M']);
        ProductSize::create(['name' => 'Large', 'slug' => 'L']);
        ProductSize::create(['name' => 'Extra Large', 'slug' => 'XL']);
        ProductSize::create(['name' => 'Extra Extra Large', 'slug' => 'XXL']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sizes');
    }
};
