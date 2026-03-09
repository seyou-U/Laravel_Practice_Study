<?php

namespace Database\Seeders;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(DatabaseManager $manager, Hasher $hasher): void
    {
        $datetime = now()->toDateTimeString();
        $userId = $manager->table('users')
            ->insertGetId(
                [
                    'name' => 'laravel user',
                    'email' => 'mail@example.com',
                    'phone' => '080-0000-0000',
                    'password' => $hasher->make('password'),
                    'created_at' => $datetime,
                ]
            );
        $manager->table('user_tokens')
            ->insert(
                [
                    'user_id' => $userId,
                    'api_token' => Str::random(60),
                    'created_at' => $datetime,
                ]
            );
    }
}
