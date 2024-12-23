<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Two\GithubProvider;
use Psr\Log\LoggerInterface;

// 外部サービスからコールバックされ取得したユーザー情報をもとに利用する
final class CallbackActionController extends Controller
{
    public function __invoke(
        Factory $factory,
        AuthManager $authManager,
        LoggerInterface $log): RedirectResponse
    {
        /** @var GithubProvider $driver */
        // driverとしてgithubを設定する
        $driver = $factory->driver('github');
        // コールバック時にSocialiteのメソッドを介しユーザー情報を取得する (ログ出力含む)
        $user = $driver->setHttpClient(
            new Client([
                'handler' => tap(
                    HandlerStack::create(),
                    function (HandlerStack $stack) use ($log) {
                        $stack->push(Middleware::log($log, new MessageFormatter()));
                    })
            ])
        )->user();

        // 外部サービスから取得したユーザー情報をDBに登録しログイン処理を行う
        $authManager->guard()->login(
            User::firstOrCreate([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => '',
            ]),
            true
        );

        return redirect('/home');
    }
}
