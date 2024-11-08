<?php

namespace App\Providers;

use App\Auth\CacheUserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * 自作認証ドライバの登録
     */
    public function boot(): void
    {
        // Gate::policy()を呼び出す
        $this->registerPolicies();

        // 第1引数にprovider名、第2引数に実装したメソッドのインスタンスを返却するコールバックを指定する
        $this->app->make('auth')->provider(
            'cache_eloquent',
            function (Application $app, array $config) {
                // 第1引数にアプリケーションのインスタンス、第2引数にconfigの設定値を指定する
                return new CacheUserProvider(
                    $app->make('hash'),
                    $config['model'],
                    $app->make('cache')->driver()
                );
            }
        );
    }
}
