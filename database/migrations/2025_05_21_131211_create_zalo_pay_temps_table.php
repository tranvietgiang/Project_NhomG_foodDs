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
        Schema::create('zalo_pay_temps', function (Blueprint $table) {
            $table->id();
            $table->string('trans_id')->unique(); // apptransid
            $table->unsignedBigInteger('user_id');
            $table->json('data'); // lưu arr1
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zalo_pay_temps');
    }
};