<?php

namespace App\Providers;

use App\Auth\Password\PasswordManager;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

// PasswordBrokerManagerをクラス継承したクラスをアプリケーション内で用いるためにサービスプロパイダをここで定義
// → 本クラスをconfig/app.phpのprovidersキーに登録する必要あり
class PasswordServiceProvider extends PasswordResetServiceProvider
{
    // 独自のパスワードリセットクラスの特録方法
    protected function registerPasswordBroker(): void
    {
        // 継承元(PasswordResetServiceProvider)では、PasswordBrokerManagerを返却していた
        // そのため、本クラスで自作したカスタマイズクラスのインスタンスを返却するようにする
        $this->app->singleton(
            'auth.password',
            function (Application $app) {
                return new PasswordManager($app);
            }
        );

        $this->app->bind(
            'auth.password.broker',
            function (Application $app) {
                return $app->make('auth.password')->broker();
            }
        );
    }
}
