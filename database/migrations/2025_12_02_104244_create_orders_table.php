<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->string('payment_method')->default('cash');
            $table->string('status')->default('new');
            $table->unsignedBigInteger('total');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
