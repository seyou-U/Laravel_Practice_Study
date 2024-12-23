<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\Factory;

// 外部サービス認証ページへのリダイレクトするクラス
final class RegisterActionController extends Controller
{
    public function __invoke(Factory $factory): RedirectResponse
    {
        // driverメソッドで外部サービスを指定する
        return $factory->driver('github')->redirect();
    }
}
