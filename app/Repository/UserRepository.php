<?php

namespace App\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        $users = User::all();

        return $users;
    }

    public function find(int $id): array
    {
        $user = User::find($id)->toArray();

        // ユーザー情報の抽出などの処理
        return $user;
    }
}
