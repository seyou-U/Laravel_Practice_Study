<?php

use App\Http\Actions\PublisherAction;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\UserActionController;
use App\Http\Controllers\User\LoginActionController;
use App\Http\Controllers\User\RetrieveActionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function () {
    // ログインを行い、アクセストークンを発行する
    Route::post('/users/login', LoginActionController::class);
    Route::post('/publishers', [PublisherAction::class, 'create']);
    // アクセストークンを用いて、認証ユーザーの情報を取得する
    // Route::post('/users/', RetrieveActionController::class)
    //     ->middleware('auth:jwt');
    // 認可処理を適応させたい場合に使用する。パスにidを渡す
    // Sanctum動作確認のために下記実装についてコメントアウト
    // Route::post('/users/{id}', RetrieveActionController::class)
    //     ->middleware('auth:jwt');

    Route::middleware('auth:sanctum')->group(function(){
        // 認証ユーザー情報
        Route::get('/user', UserActionController::class);
        // 認証ユーザーの詳細取得
        Route::get('/users/me', RetrieveActionController::class);
    });

    // Reactとの疎通確認のため直接記述 (簡易的な動作確認を行うために一時こちらに全て記述)
    Route::get('/products', function (Request $request) {
        $q = (string) $request->query('q', '');
        $onlyInStock = request()->boolean('onlyInStock');

        $items = [
            ['id' => 1, 'name' => 'Football', 'category' => 'Sporting Goods', 'price' => 49.99, 'stocked' => true],
            ['id' => 2, 'name' => 'Baseball', 'category' => 'Sporting Goods', 'price' => 9.99, 'stocked' => true],
            ['id' => 3, 'name' => 'iPod Touch', 'category' => 'Electronics', 'price' => 99.99, 'stocked' => true],
            ['id' => 4, 'name' => 'iPhone 15', 'category' => 'Electronics', 'price' => 999.99, 'stocked' => false],
        ];

        // 検索
        if ($q !== '') {
            $items = array_values(array_filter($items, function ($p) use ($q) {
                return stripos($p['name'], $q) !== false;
            }));
        }

        // 在庫ありのみ
        if ($onlyInStock) {
            $items = array_values(array_filter($items, fn ($p) => $p['stocked'] === true));
        }

        return response()->json($items);
    });
});

Route::resource('memos', MemoController::class);
