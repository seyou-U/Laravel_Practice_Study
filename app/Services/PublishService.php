<?php

namespace App\Services;

use App\DataProvider\Eloquent\Publisher;

class PublishService
{
    /**
     * 引数で指定された名前と同じ出版名あるか確認
     */
    public function exists(string $name): Bool
    {
        $count = Publisher::whereName($name)->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }

    /**
     * 引数の内容から新しく出版社を登録し、登録した出版社のidを返却する
     */
    public function store(string $name, string $address): Int
    {
        $publisher = Publisher::create([
            'name' => $name,
            'address' => $address,
        ]);
        return $publisher->id;
    }
}
