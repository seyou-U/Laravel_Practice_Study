<?php

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\Publisher;
use App\Models\User;
use Database\Factories\PublisherFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '080-0000-0000',
                'password' => Hash::make('password'),
            ]
        );

        // seederクラスはcallメソッドを用いて呼び出す
        $this->call(AuthorsTableSeeder::class);

        // // Factoryクラスはcreateメソッドを用いることで作成することができる
        Publisher::factory(50)->create();

        // $this->call(
        //     [
        //         UserSeeder::class,
        //     ]
        // );

        // 10件以上でページが切り替わるページネーションについて動作確認するためにダミーデータを10件作成する
        Memo::factory()->count(10)->create(['user_id' => $user->id]);

        $this->call(ProductSeeder::class);
    }
}
