<?php

namespace Database\Seeders;

use App\Models\Publisher;
use App\Models\User;
use Database\Factories\PublisherFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // seederクラスはcallメソッドを用いて呼び出す
        $this->call(AuthorsTableSeeder::class);

        // Factoryクラスはcreateメソッドを用いることで作成することができる
        Publisher::factory(50)->create();

        $this->call(
            [
                UserSeeder::class,
            ]
        );
    }
}
