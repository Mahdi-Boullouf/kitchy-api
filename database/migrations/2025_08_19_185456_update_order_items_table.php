<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->integer('price')->default(0);
            }
            if (!Schema::hasColumn('order_items', 'net_price')) {
                $table->integer('net_price')->default(0);
            }
            if (!Schema::hasColumn('order_items', 'color_id')) {
                $table->unsignedBigInteger('color_id')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'quantity', 'price', 'net_price', 'color_id']);
        });
    }
};