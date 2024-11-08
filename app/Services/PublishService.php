<?php

namespace App\Services;

use App\DataProvider\Eloquent\Publisher;
use App\Interfaces\PublisherRepositoryInterface;

class PublishService
{
    private $publisher;

    public function __construct(PublisherRepositoryInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * 引数で指定された名前と同じ出版名あるか確認
     */
    public function exists(string $name): Bool
    {
        if (empty($this->publisher->findByName($name))) {
            return false;
        }
        return true;
    }

    /**
     * 引数の内容から新しく出版社を登録し、登録した出版社のidを返却する
     */
    public function store(string $name, string $address): Int
    {
        return $this->publisher->store(app()->make(Publisher::class, ['id' => null, 'name' => $name, 'address' => $address]));
    }
}
