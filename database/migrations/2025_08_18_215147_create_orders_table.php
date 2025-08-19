<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile_number');
            $table->string('wilaya');
            $table->string('commune'); // "commun" typo fixed
            $table->string('exact_address');
            $table->enum('status', ['pending','confirmed','shipped','delivered','cancelled'])->default('pending');
            $table->boolean('hidden')->default(false);
            $table->unsignedBigInteger('subtotal')->default(0); // cents
            $table->unsignedBigInteger('total')->default(0); // cents
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('price'); // unit price (selling) in cents at time of order
            $table->unsignedBigInteger('net_price')->default(0); // unit cost at time of order (for stats)
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};