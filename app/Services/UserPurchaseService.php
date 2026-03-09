<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Purchase;
use App\Models\User;

class UserPurchaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
        $users = $this->userRepository->all();

        return $users;
    }

    /**
     * レイヤードアーキテクチャに基づきServiceメソッド作成
     */
    public function retrievePurchase(int $userId)
    {
        // レポジトリ層を用いる前の実装
        // $user = User::find($userId);
        // $user->purchase = Purchase::findAllBy($userId);

        // レポジトリ層を用いた時の実装
        $user = $this->userRepository->find($userId);

        // データベースから取得した値を用いた処理などについて記述する
        return $user;
    }
}
