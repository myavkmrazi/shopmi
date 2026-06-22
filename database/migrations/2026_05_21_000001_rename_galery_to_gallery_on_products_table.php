<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('products', 'galery') && ! Schema::hasColumn('products', 'gallery')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('galery', 'gallery');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'gallery') && ! Schema::hasColumn('products', 'galery')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('gallery', 'galery');
            });
        }
    }
};
