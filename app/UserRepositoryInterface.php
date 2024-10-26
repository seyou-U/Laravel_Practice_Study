<?php

namespace App;

interface UserRepositoryInterface
{
    public function find(int $id): array;
}
