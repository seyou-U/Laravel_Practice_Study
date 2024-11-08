<?php

namespace App\Auth\Password;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Str;

// パスワードリセット方法のカスタマイズ(元のクラスを継承)
class PasswordManager extends PasswordBrokerManager
{
    /**
     * コンストラクタ.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     *
     * @param  array  $config
     * @return CustomTokenRepository
     */
    public function createTokenRepository(array $config)
    {
        $key = $this->app['config']['app.key'];

        // $keyが「base64:」から始まっているかどうか判定する
        if (Str::startsWith($key, 'base64:')) {
            // デコードで文字を元に戻す
            $key = base64_decode(substr($key, 7));
        }

        $connection = $config['connection'] ?? null;

        // DatabaseTokenRepositoryを継承したクラスを戻り値にする必要がある。
        // また、独自処理に置き換えることから、TokenRepositoryInterfaceを実装したクラスにする必要もある。
        return new CustomTokenRepository(
            $this->app['db']->connection($connection),
            $this->app['hash'],
            $config['table'],
            $key,
            $config['expire'],
            $config['throttle'] ?? 0
        );
    }
}
