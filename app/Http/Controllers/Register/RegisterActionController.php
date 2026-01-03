<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Interfaces\RegisterReviewProviderInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

// 外部サービス認証ページへのリダイレクトするクラス
final class RegisterActionController extends Controller
{
    private $provider;
    private $dispatcher;
    private $socialite;

    // データベース登録とEvent発火に伴うクラスのインスタンスが渡される
    public function __construct(
        RegisterReviewProviderInterface $provider,
        Dispatcher $dispatcher,
        SocialiteFactory $socialite
    ) {
        $this->provider = $provider;
        $this->dispatcher = $dispatcher;
        $this->socialite = $socialite;
    }
    public function __invoke(Request $request): RedirectResponse
    {
        // driverメソッドで外部サービスを指定する
        // return $factory->driver('github')->redirect();
        $driver = $request->string('provider', 'github')->toString();

        // Amazonドライバを利用する場合
        // return $factory->driver('amazon')->redirect();

        $created = now()->toDateTimeString();
        return $this->socialite->driver($driver)->redirect();
    }
}
