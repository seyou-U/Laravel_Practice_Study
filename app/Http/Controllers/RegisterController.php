<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        // リクエストの内容をファザードで記述する方法
        // $user = User::create([
        //     'name' => FacadesRequest::get('name'),
        //     'email' => FacadesRequest::get('email'),
        //     'password' => Hash::make($request->password),
        // ]);

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
