<?php

namespace App\Providers;

use App\BlowfishEncrypter;
use App\Class\Complex;
use App\Class\MailSender;
use App\Class\PushSender;
use App\Listeners\RegisteredListener;
use App\Services\AdminService;
use App\Services\UserService;
use App\Interfaces\NotifierInterface;
use App\Interfaces\PublisherRepositoryInterface;
use App\Repository\PublisherRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Encryption\MissingAppKeyException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * サービスプロパイダの読み込み完了後に実行したい処理について記述
     */
    public function register(): void
    {
        //インスタンス生成時に他のクラスを利用する必要がある場合はここにバインド処理
        app()->bind(Complex::class, function(Application $app) {
            // Loggerクラスのインスタンス生成のため文字列を渡す
            $logger = $app->make(Logger::class, ['name' => '複雑なbindが成功しました']);
            $complex = new Complex($logger, $logger->getName());
            return $complex;
        });

        // インターフェイスと実装の結合
        $this->app->bind(
            PublisherRepositoryInterface::class,
            PublisherRepository::class
        );

        // 作成したコントラクトのバインドを定義する
        // $this->app->singleton('encrypter', function (Application $app) {
        //         // config/app.phpからアプリケーションの情報を取得する
        //         $config = $app->make('config')->get('app');
        //         return new BlowfishEncrypter($this->parseKey($config));
        //     }
        // );
    }

    /**
     * アプリケーションサービスへのブートストラップ処理 (アプリケーションが起動する際に割り込んで実行される処理)を記述
     */
    public function boot(): void
    {
        Event::listen(
            RegisteredListener::class,
        );

        // 通常はここにバインド処理を記述
        // インターフェイス通常のバインド例
        app()->bind(NotifierInterface::class, function() {
            return new MailSender();
        });

        // 呼び出すクラスに応じて異なるインスタンスを取得することができる
        // 下記では、UserServiceクラスでNotifierInterfaceクラスインスタンスを生成した場合、PushSenderクラスのインスタンスが返却される
        app()->when(UserService::class)
            ->needs(NotifierInterface::class)
            ->give(function() {
                return new PushSender();
            });

        // AdminクラスでNotifierInterfaceクラスインスタンスを生成した場合、MailSenderクラスのインスタンスが返却される
        app()->when(AdminService::class)
            ->needs(NotifierInterface::class)
            ->give(function() {
                return new MailSender();
            });
    }

    protected function parseKey(array $config)
    {
        // keyの値の文字列が「base64:」から始まっていることをチェックする
        if (Str::startsWith($key = $this->key($config), $prefix = 'base64:')) {
            // afterメソッドを用いることでbase64から後に続く文字列を取得し、デコードする
            $key = base64_decode(Str::after($key, $prefix));
        }

        return $key;
    }

    protected function key(array $config)
    {
        // tapヘルパでは、クロージャーを渡していることから主に第一引数を返却している
        return tap(
            $config['key'],
            function ($key) {
                if (empty($key)) {
                    throw new MissingAppKeyException();
                }
            }
        );
    }
}
