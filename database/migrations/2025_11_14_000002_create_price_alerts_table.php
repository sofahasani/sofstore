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
        Schema::create('price_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('original_price', 15, 2);
            $table->decimal('current_price', 15, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->boolean('is_notified')->default(false);
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'is_notified']);
            $table->index(['product_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_alerts');
    }
};
