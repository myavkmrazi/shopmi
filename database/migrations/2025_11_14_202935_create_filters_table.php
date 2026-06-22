<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('filter_group_id')->constrained('filter_groups');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
