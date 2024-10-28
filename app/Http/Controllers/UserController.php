<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\UserPurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserPurchaseService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request): View
    {
        $result =  $this->service->retrievePurchase($request->get('id'));

        return view('user.show', compact('result'));
    }

    // 引数でUserRegisterRequestクラスのインスタンスを渡す
    public function register(UserRegisterRequest $request)
    {
        // UserRegisterRequestを引数にすることでここまでに来るまでにバリデーション判定が行われている

        // 全ての入力値を取得し、$inputに保存する
        $inputs = $request->all();

        // バリデーションのルールを定義する
        // $rules = [
        //     'name' => 'required',
        //     'age' => 'integer',
        // ];

        // バリデーションの実行.エラーの場合は直前の画面にリダイレクトする
        // $this->validate($request, $rules);
        // // ここにバリデーション通過後の処理
        // $name = $request->get('name');


        // バリデータクラスのインスタンスを取得する。直前の画面ではなく特定の画面に遷移させたい場合に使用する
        // $validate = Validator::make($inputs, $rules);

        // if ($validate->fails()) {
        //     // 値エラーの場合の処理
        // }

        // バリデーション追加後の処理について記述する
    }

    public function store(Request $request): RedirectResponse
    {
        // 登録処理など
    }
}
