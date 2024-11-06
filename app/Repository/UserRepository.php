<?php

namespace App\Repository;

use App\Models\User;
use App\Interfaces\NotifierInterface;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function find(int $id): array
    {
        $user = User::find($id)->toArray();
        // ユーザー情報の抽出などの処理
        return $user;
    }
}
