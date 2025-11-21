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
            $table->string('ref_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Product details at time of order
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->string('product_image')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('total_amount', 10, 2);
            
            // Shipping address
            $table->string('address');
            $table->string('locality');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('address_type'); // Home, Office, Other
            
            // Payment details
            $table->string('payment_method'); // credit_card, cod
            $table->string('cardholder_name')->nullable();
            $table->string('card_number')->nullable(); // Store last 4 digits only for security
            $table->timestamp('payment_time');
            
            // Order status
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('processing');
            
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
