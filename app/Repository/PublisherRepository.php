<?php

namespace App\Repository;

use App\DataProvider\Eloquent\Publisher as EloquentPublisher;
use App\Domain\Entity\Publisher;
use App\Interfaces\PublisherRepositoryInterface;

// データベースを操作するRepositoryクラス
class PublisherRepository implements PublisherRepositoryInterface
{
    private $eloquentPublisher;

    public function __construct(EloquentPublisher $eloquentPublisher)
    {
        $this->eloquentPublisher = $eloquentPublisher;
    }

    public function findByName(string $name): ?Publisher
    {
        $record = $this->eloquentPublisher->whereName($name)->first();
        if (empty($record)) {
            return null;
        }

        return app()->make(Publisher::class, ['id' => $record->id, 'name' => $record->name, 'address' => $record->address]);
    }

    public function store(Publisher $publisher): int
    {
        $eloquent = $this->eloquentPublisher->newInstance();
        $eloquent->name = $publisher->getAddress();
        $eloquent->address = $publisher->getAddress();

        return $eloquent->id;
    }
}
