<?php

namespace App\Gate;

use App\Models\User;
use function intval;

// 1つの認可処理を1つのクラスとして表現する場合
final class UserAccess
{
    // intvalメソッドは変数の整数としての値を取得する
    public function __invoke(User $user, string $id)
    {
        return intval($user->getAuthIdentifier()) === intval($id);
    }
}
