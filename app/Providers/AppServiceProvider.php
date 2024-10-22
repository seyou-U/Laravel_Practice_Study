<?php

namespace App\Providers;

use App\Class\Complex;
use App\Class\MailSender;
use App\Class\PushSender;
use App\Listeners\RegisteredListener;
use App\Services\AdminService;
use App\Services\UserService;
use App\NotifierInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;

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
}
