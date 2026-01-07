<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

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
