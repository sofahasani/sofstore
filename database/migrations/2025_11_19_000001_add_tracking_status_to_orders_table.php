<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_status')->nullable()->after('status');
            $table->text('tracking_notes')->nullable()->after('tracking_status');
            $table->timestamp('status_updated_at')->nullable()->after('tracking_notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_status', 'tracking_notes', 'status_updated_at']);
        });
    }
};
