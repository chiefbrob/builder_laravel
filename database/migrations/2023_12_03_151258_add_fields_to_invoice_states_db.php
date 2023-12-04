<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice_states', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('user_id');
            $table->string('previous_status');
            $table->string('status');
            $table->string('notes')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_states', function (Blueprint $table) {
            $table->dropColumn('invoice_id');
            $table->dropColumn('user_id');
            $table->dropColumn('previous_status');
            $table->dropColumn('status');
        });
    }
};
