<?php

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gross_value');
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('shipping_value')->default(0);
            $table->unsignedBigInteger('net_value');
            $table->foreignId('coupon_id')->nullable();
            $table->integer('cep');
            $table->string('house_number');
            $table->string('email');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
