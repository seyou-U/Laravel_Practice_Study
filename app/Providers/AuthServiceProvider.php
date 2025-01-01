<?php

namespace App\Providers;

use App\Auth\CacheUserProvider;
use App\Auth\UserTokenProvider;
use App\DataProvider\UserToken;
use App\Gate\UserAccess;
use App\Models\Content;
use App\Models\User;
use App\Policies\ContentPolicy;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Psr\Log\LoggerInterface;
use stdClass;

class AuthServiceProvider extends ServiceProvider
{
    // Eloquentモデルを利用したポリシー
    // protected $policies = [
    //     Content::class => ContentPolicy::class,
    // ];

    // Eloquentモデルを利用しないポリシー
    protected $policies = [
        stdClass::class => ContentPolicy::class,
    ];

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
    public function boot(Gate $gate, LoggerInterface $logger): void
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

        // APIトークン認証
        // 認証ドライバ名user_token
        $this->app->make('auth')->provider(
            'user_token',
            function (Application $app, array $config) {
                // UserTokenクラスはDatabaseManagerクラスが使われている。
                // DatabaseManagerクラスはサービスコンテナでdbの名前で登録されている
                return new UserTokenProvider(new UserToken($app->make('db'))                );
            }
        );

        // ログインしているユーザーにのみアクセスを許可する認可処理
        // define : 認可処理に名前を付けて、紐付く処理をクロージャで記述する
        // (クロージャの戻り値は真偽値型になる、クロージャの他にもクラス名@メソッド名で記述する方法もある)
        // $idはGateで提供されているallowsメソッドもしくはcheckメソッドで指定する値
        // 下記は直接認可処理について記述する場合
        $gate->define('user-access', function (User $user, $id) {
            return intval($user->getAuthIdentifier()) === intval($id);
        });

        // 1つの認可処理を表現したクラスをインスタンス化して呼び出す
        $gate->define('user-access', new UserAccess);

        // before : 認可処理を実行させる前に動作させる
        // この後実行される処理でどのユーザーがアクセスしたか残すログ
        $gate->before(function ($user, $ability) use ($logger) {
            $logger->info($ability, [
                'user_id' => $user->getAuthIdentifier()]
            );
        });
    }
}
