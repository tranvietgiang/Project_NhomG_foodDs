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
        Schema::create('list_hearts', function (Blueprint $table) {
            $table->id('heart_id');
            $table->string('heart_name');
            $table->double('heart_price');
            $table->integer('heart_amount')->default(0);
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->string('heart_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_hearts');
    }
};