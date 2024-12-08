<?php

namespace App\Auth;

use App\Entity\User;
use App\Interfaces\UserTokenProviderInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

// 今回はAPIトークン認証のみを想定して作成したが、Webアプリケーションの認証処理を兼用する場合は各メソッドに処理を記述する
final class UserTokenProvider implements UserProvider
{
    private $provider;

    public function __construct(UserTokenProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function retrieveById($identifier)
    {
        return null;
    }

    public function retrieveUserByToken($identifier, string $token)
    {
        return null;
    }

    // APIアプリケーションで自動ログイン機能は利用できないため記述しない
    public function updateRememberToken(Authenticatable $user, $token)
    {

    }

    // ユーザー認証の際に最終的に通るメソッド
    public function retrieveByCredentials(array $credentials)
    {
        if (!isset($credentials['api_token'])) {
            return null;
        }

        // api_tokenを元にユーザー情報を取得
        $result = $this->provider->retrieveUserByToken($credentials['api_token']);
        if (empty($result)) {
            return null;
        }

        // App\Entity\Userクラスのインスタンスを返却することで認証処理後にユーザー情報にアクセスすることができる
        return new User(
            $result->user_id,
            $result->api_token,
            $result->name,
            $result->email
        );
    }

    // APIアプリケーションではパスワード認証は利用しないため、ログインできないことを示すfalseを返却
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return false;
    }

    public function retrieveByToken($identifier, $token)
    {

    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {

    }
}
