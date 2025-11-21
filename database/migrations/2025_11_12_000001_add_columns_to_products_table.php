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
        Schema::table('products', function (Blueprint $table) {
            // Add SKU at the beginning
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->unique()->nullable()->after('id');
            }
            
            // Add category and brand
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable()->after('category');
            }
            
            // Add stock (yang penting!)
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }
            
            // Add weight, dimensions after stock
            if (!Schema::hasColumn('products', 'weight')) {
                $table->integer('weight')->nullable()->comment('Weight in grams')->after('stock');
            }
            if (!Schema::hasColumn('products', 'dimensions')) {
                $table->string('dimensions')->nullable()->comment('L x W x H in cm')->after('weight');
            }
            
            // Add tags after description
            if (!Schema::hasColumn('products', 'tags')) {
                $table->json('tags')->nullable()->after('description');
            }
            
            // Add condition, warranty after brand
            if (!Schema::hasColumn('products', 'condition')) {
                $table->enum('condition', ['new', 'like_new', 'good', 'fair'])->default('new')->after('brand');
            }
            if (!Schema::hasColumn('products', 'warranty')) {
                $table->string('warranty')->nullable()->after('condition');
            }
            
            // Add discount price after price
            if (!Schema::hasColumn('products', 'discount_price')) {
                $table->decimal('discount_price', 10, 2)->nullable()->after('price');
            }
            
            // Add status flags and metrics
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('dimensions');
            }
            if (!Schema::hasColumn('products', 'total_sold')) {
                $table->integer('total_sold')->default(0)->after('is_active');
            }
            if (!Schema::hasColumn('products', 'rating')) {
                $table->decimal('rating', 3, 2)->default(0)->after('total_sold');
            }
            if (!Schema::hasColumn('products', 'review_count')) {
                $table->integer('review_count')->default(0)->after('rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'sku', 'category', 'brand', 'stock', 'weight', 
                'dimensions', 'tags', 'condition', 'warranty',
                'discount_price', 'is_active', 'total_sold', 
                'rating', 'review_count'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
