<?php

namespace App\Interfaces;

interface RegisterReviewProviderInterface
{
    public function save(
        string $title,
        string $content,
        int $userId,
        string $createdAt,
        array $names = []
    ): int;
}
