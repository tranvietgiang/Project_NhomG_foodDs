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
        Schema::create('bills', function (Blueprint $table) {
            $table->id('bill_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cart_id')->constrained('carts', 'cart_id');
            $table->foreignId('method_payment_id')->constrained('method_payments', 'method_payment_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};