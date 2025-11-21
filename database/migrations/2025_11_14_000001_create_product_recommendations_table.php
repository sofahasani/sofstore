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
        Schema::create('product_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('recommended_product_id')->constrained('products')->onDelete('cascade');
            $table->enum('type', ['similar', 'frequently_bought', 'trending', 'personalized', 'bundle']);
            $table->decimal('score', 8, 2)->default(0); // Recommendation score/confidence
            $table->integer('count')->default(1); // How many times recommended together
            $table->timestamps();

            // Indexes with custom names to avoid MySQL 64-char limit
            $table->index(['product_id', 'type', 'score'], 'pr_product_type_score_idx');
            $table->index(['type', 'score'], 'pr_type_score_idx');
            $table->unique(['product_id', 'recommended_product_id', 'type'], 'pr_product_recommended_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_recommendations');
    }
};
