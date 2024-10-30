<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        return view('regist.register');
    }

    // メソッドインジェクションを用いることでRequestオブジェクトを用いた参照パターンを実装
    public function store(Request $request)
    {
        // [memo] confirmedは別のフィールドと一致しているかどうかのチェック
        // nameに対し、「ascii_alpha」というカスタムルールを追加
        $rule = [
            'name' => 'required|string|max:255|ascii_alpha',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ];

        $inputs = $request->all();

        // バリデーションルールに「ascii_alpha」を追加
        Validator::extend('ascii_alpha', function($attribute, $value, $parameter) {
            // 半角アルファベットならtrue(バリデーションOK)
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

        $validator = Validator::make($inputs, $rule);
        // 特定の条件のみバリデーションを追加する場合、sometimesメソッドを用いる
        // 第三引数のクロージャがtrueの場合、第一引数の入力項目に対し第二引数のルールを適応する
        $validator->sometimes(
            'age',
            'integer|min:18',
            function ($inputs) {
                return $inputs->mailmagazine === 'allow';
            }
        );

        if ($validator->fails()) {
            // バリデーションエラーの場合の処理を記述
            return redirect('create');
        }


        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);


        // リクエストの内容をファザードで記述する方法
        $user = User::create([
            'name' => FacadesRequest::get('name'),
            'email' => FacadesRequest::get('email'),
            'password' => Hash::make($request->password),
        ]);

        // 特定の入力値のみを取得する場合は
        // $inputs = FacadesRequest::only(['name', 'age']);
        // $name = $inputs['name'];


        // Requestオブジェクト
        // アップロードのファイルを取得したい場合はfileメソッドを用いる
        // $file = FacadesRequest::file('material');
        // $content = file_get_contents($file->getRealPath());

        // JSONの扱いについて
        // JSONはgetメソッドもしくはjsonメソッドを用いて取得することができる。
        // $request_get = $request->get('nested');
        // $request_json = $request->json('nested');

        // 会員登録時のメール送信イベントの着火
        event(new Registered($user));

        return view('regist.complete', compact('user'));
    }
}
