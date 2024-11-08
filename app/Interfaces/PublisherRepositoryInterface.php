<?php

namespace App\Interfaces;

use App\Domain\Entity\Publisher;

// Repositoryを抽象化するためのインターフェイス
interface PublisherRepositoryInterface
{
    public function findByName(string $name): ?Publisher;

    public function store(Publisher $publisher): int;
}
