<?php

namespace App\DataProvider;

use App\Interfaces\UserTokenProviderInterface;
use Illuminate\Database\DatabaseManager;
use stdClass;

final class UserToken implements UserTokenProviderInterface
{
    private $manager;
    private $table = 'user_tokens';

    /**
     * コンストラクタ
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * tokenからユーザー情報を検索する処理
     * @param string $token
     * @return stdClass|null
     */
    public function retrieveUserByToken(string $token): ?stdClass
    {
        // user_tokensテーブルからレコードを検索する処理
        return $this->manager->connection()
            ->table($this->table)
            ->join('users', 'users.id', '=', 'user_tokens.user_id')
            ->where('api_token', $token)
            ->first(['user_id', 'api_token', 'name', 'email']);
    }
}
