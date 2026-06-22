<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
       public function run(): void
    {
       
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'is_admin' => true,
            'email_verified_at' => now(),
            'password' => '123456',
            'remember_token' => Str::random(10),
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            FilterSeeder::class,
        ]);
    }
}
