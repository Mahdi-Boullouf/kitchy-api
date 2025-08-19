<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','called','sent','delivered','cancelled','failed','returned') DEFAULT 'pending'");
    }

    public function down(): void {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','called','sent','delivered','cancelled','failed') DEFAULT 'pending'");
    }
};