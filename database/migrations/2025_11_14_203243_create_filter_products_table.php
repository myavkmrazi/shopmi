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
        Schema::create('filter_products', function (Blueprint $table) {
            $table->foreignId('filter_id')->constrained('filters');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('filter_group_id')->constrained('filter_groups');
            $table->primary(['filter_id', 'product_id']);
            $table->index('filter_id', 'filter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_products');
    }
};
