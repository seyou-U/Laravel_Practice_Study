<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 投入データを任意に作成する
        // for ($i = 1; $i <= 10; $i++) {
        //     $author = [
        //         'name' => '著名者' . $i,
        //         'kana' => 'チョシャメイ' . $i,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        //     DB::table('authors')->insert($author);
        // }

        // Fakerを用いてランダムに作成する
        $faker = Factory::create('ja_JP');
        for ($i = 1; $i <= 10; $i++) {
            $author = [
                'name' => $faker->name,
                'kana' => $faker->kanaName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('authors')->insert($author);
        }
    }
}
