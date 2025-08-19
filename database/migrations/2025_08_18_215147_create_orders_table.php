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
            $table->enum('status', ['pending','called','sent','delivered','cancelled','failed'])->default('pending');
            $table->boolean('hidden')->default(false);
            $table->unsignedBigInteger('subtotal')->default(0); // cents
            $table->unsignedBigInteger('total')->default(0); // cents
            $table->timestamps();
        });

  Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->cascadeOnDelete();
    $table->foreignId('product_id')->constrained()->cascadeOnDelete();
    $table->foreignId('color_id')->nullable()->constrained('colors');

    $table->integer('quantity')->default(1);
    $table->integer('price')->default(0);
    $table->integer('net_price')->default(0);
    $table->timestamps();
});
    }
    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};