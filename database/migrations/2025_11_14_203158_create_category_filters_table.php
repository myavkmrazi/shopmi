<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_filters', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('filter_group_id')->constrained('filter_groups');
            $table->primary(['category_id', 'filter_group_id'])->constrained('filter_groups');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_filters');
    }
};
