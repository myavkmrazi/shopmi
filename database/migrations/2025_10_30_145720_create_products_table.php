<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained();
            $table->string('excerpt')->nullable();
            $table->text('content');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('old_price')->default(0);
            $table->string('image')->nullable();
            $table->text('gallery')->nullable();
            $table->boolean('is_hit')->default(false);
            $table->boolean('is_new')->default(false);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
