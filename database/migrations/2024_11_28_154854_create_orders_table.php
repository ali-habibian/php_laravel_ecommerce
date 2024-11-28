<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('user_address_id')->constrained('user_addresses');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('delivery_charge')->default(0);
            $table->unsignedInteger('coupon_discount')->default(0);
            $table->unsignedInteger('paying_amount');
            $table->enum('payment_method', ['pos', 'cash', 'shabaNumber', 'cardToCard', 'online']);
            $table->tinyInteger('payment_status')->default(0);
            $table->text('description')->nullable();
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
