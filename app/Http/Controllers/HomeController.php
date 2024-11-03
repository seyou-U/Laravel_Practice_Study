<?php

namespace App\Http\Controllers;

use App\Class\Complex;
use App\Class\PushSender;
use App\Models\Author;
use App\NotifierInterface;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 名前解決方法について以下の2通りがある (makeメソッドもしくはappヘルパー)
        // app()->make(Complex::class)->setup();
        // app(Complex::class)->setup();

        // bindが定義されていないクラスのインスタンス生成とパラメータの受け渡しを確認
        // dd(app(Unbinding::class, ['name' => 'test']));

        // callメソッドを用いたメソッドインジェクションの確認
        // callメソッドの第一引数で実行するクラス変数とメソッド、第二引数でメソッドインジェクションで注入する値以外の引数を指定
        // $service = app(UserService::class);
        // app()->call([$service, 'sendNotification'], ['to' => 'address', 'message' => 'message']);

        // コンテキストに応じた解決 (異なるインスタンスを要求するクラス)
        // whenメソッド→引数に注入先のクラス名を指定する / needs

        // タイプヒンティングにインターフェイス名を指定し、呼び出すクラス名で異なるインスタンスを取得することもできる

        // 異なるインスタンスを要求するクラスについて検証
        app()->make(UserService::class);
        app()->make(AdminService::class);

        // aliasについて、config/app.phpからIlluminate\Support\Facades\Facadeファイルに定義されている
        // Illuminate\Support\Facades\Configクラスにgetメソッドはないが、
        // getFacadeAccessorメソッドで取得した文字列をresolveFacadeInstanceメソッドで解決し取得したインスタンスを返却する
        // その後、__callStaticメソッドの引数であるmethodが実行される(今回はgetメソッド)
        // dd(Config::get('app.debug'));

        // 自作したアクセサの動作確認用
        // $authors = Author::all();
        // $authors->each(function ($author){
        //     echo $author->kana;
        // });

        return view('home');
    }

    public function store(Request $request): RedirectResponse
    {
        // 自作したミューテータの動作確認
        // Author::create([
        //     'name' => 'テスト',
        //     'kana' => 'ﾃｽﾄ',
        // ]);

        // データがない場合のみ登録する (firstOrCreateメソッド)
        Author::firstOrCreate([
            'name' => '著者A',
            'kana' => 'ﾃｽﾄ',
        ]);

        return redirect('home');
    }
}
