<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

// データーベースとキャッシュを併用したドライバを定義したクラス
class CacheUserProvider extends EloquentUserProvider
{
    protected $cache;
    protected $lifetime;
    protected $cacheKey = "authentication:user:%s";
    /**
     * コンストラクタ
     *
     * @param Hasher  $hasher
     * @param string  $model
     * @param CacheRepository $cache,
     * @param int  $lifetime
     * @return void
     */
    public function __construct(
        HasherContract $hasher,
        string $model,
        CacheRepository $cache,
        int $lifetime = 120
    ) {
        // 継承元のコンストラクタを使用する
        parent::__construct($hasher, $model);
        $this->cache = $cache;
        $this->lifetime = $lifetime;
    }

    /**
     * nullを返却する場合を除き指定する期間で値を保持し、キャッシュを削除するまでデータベースからアクセスが発生しないようにする
     *
     * @param  mixed  $identifier
     * @return $result|null
     */
    public function retrieveById(mixed $identifier)
    {
        $cacheKey = sprintf($this->cacheKey, $identifier);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // ログイン後セッションに保持される値を利用しユーザー情報の取得を行う
        $result = parent::retrieveById($identifier);
        if (is_null($result)) {
            return null;
        }

        $this->cache->add($cacheKey, $result, $this->lifetime);

        return $result;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken(mixed $identifier, #[\SensitiveParameter] $token)
    {
        $model = $this->createModel($identifier);
        if (!$model) {
            return null;
        }

        $rememberToken = $model->getRememberToken();
        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}
