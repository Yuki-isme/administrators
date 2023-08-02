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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('sale_price')->default(0);
            $table->integer('stock');
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->integer('is_active')->default(1);
            $table->integer('is_hot')->default(0);
            $table->integer('is_feature')->default(0);
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->softDeletes();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
