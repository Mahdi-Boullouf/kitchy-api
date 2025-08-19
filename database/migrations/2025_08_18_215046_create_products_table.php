<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedBigInteger('price'); // store in cents
            $table->unsignedBigInteger('net_price'); // cost in cents
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Red"
            $table->string('hex')->nullable(); // e.g. #FF0000
            $table->timestamps();
        });

        Schema::create('color_product', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('color_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id','color_id']);
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('path'); // storage path
            $table->boolean('is_primary')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('color_product');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('products');
    }
};
