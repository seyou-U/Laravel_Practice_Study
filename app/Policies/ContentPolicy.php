<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;
use stdClass;

// contentのリソースに対する認可処理をまとめて記述するpolicyクラス
class ContentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Content $content): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Content $content): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Content $content): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Content $content): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Content $content): bool
    {
        //
    }

    /**
     * stdClassクラスのプロパティにidがあるかどうか調べ、存在する場合は認証ユーザーのidと同じ値であるか比較する
     * 同じであれば実行可能とする
     */
    public function edit(Authenticatable $authenticatable, stdClass $class): bool
    {
        if (property_exists($class, 'id')) {
            return intval($authenticatable->getAuthIdentifier()) === intval($class->id);
        }

        return false;
    }
}
