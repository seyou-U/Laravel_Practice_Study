<?php

namespace App\Http\Controllers;

use App\Class\Complex;
use App\Class\PushSender;
use App\DataAccess\BookDataAccessObject;
use App\Models\Author;
use App\Interfaces\NotifierInterface;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    private $bookDataAccessObject;

    public function __construct()
    {
        $this->bookDataAccessObject = app()->make(BookDataAccessObject::class);
    }

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

        // toSqlメソッドを用いることで発酵されるSQLについて確認することができる(実行前のSQLを取得することができる)
        // $sql = Author::where('name', '著者A')->toSql();

        // 実行されたSQLを確認する (この方法ではクエリの処理にかかった時間も確認することができることからパフォーマンスを向上させたい場合にも有効)
        // SQLの保存を有効化する
        // DB::enableQueryLog();
        // $authors = Author::find([1, 3, 5]);
        // クエリを取得する
        // $queries = DB::getQueryLog();
        // SQL保存の無効化
        // DB::disableQueryLog();

        // クエリビルダ(メソッドチェーンを用いてSQLを組み立て発酵する仕組み)について
        // DBファザードを利用したクエリビルダの発酵
        $query = DB::table('books');

        // コネクションオブジェクトから取得する場合 (コードが冗長になるため使用しない)
        // 1. サービスコンテナからDatabaseManagerクラスのインスタンスを取得する
        $db = Application::getInstance()->make('db');
        // 2. 上記インスタンスからConnectionクラスのインスタンスを取得する
        $connection = $db->connection();
        // 3. 上記インスタンスからクエリビルダを取得する
        $query = $connection->table('book');

        $result = $this->bookDataAccessObject->dataExtractionUsingSQL();
        $pdoResult = $this->bookDataAccessObject->dataExtractionUsingPdo();

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
