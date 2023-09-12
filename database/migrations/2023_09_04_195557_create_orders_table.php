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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('payment_method')->default('Thanh toán khi nhận hàng	');
            $table->string('province_code');
            $table->string('district_code');
            $table->string('ward_code');
            $table->string('street');
            $table->string('house');
            $table->string('note');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('discount');
            $table->string('payment_status')->default('Chưa thanh toán');
            $table->string('note_order')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
