<?php

use App\Http\Actions\PublisherAction;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserActionController;
use App\Http\Controllers\User\LogoutActionController;
use App\Http\Controllers\User\LoginActionController;
use App\Http\Controllers\User\RetrieveActionController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    // 認証不要
    Route::post('/users/login', LoginActionController::class);
    Route::post('/publishers', [PublisherAction::class, 'create']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);

    // アクセストークンを用いて、認証ユーザーの情報を取得する
    // Route::post('/users/', RetrieveActionController::class)
    //     ->middleware('auth:jwt');
    // 認可処理を適応させたい場合に使用する。パスにidを渡す
    // Sanctum動作確認のために下記実装についてコメントアウト
    // Route::post('/users/{id}', RetrieveActionController::class)
    //     ->middleware('auth:jwt');

    // Laravel Octaneの動作確認用のルート
    // Octaneが動作している場合、同じPIDが返ってくる
    Route::get('/octane-check', function () {
        return response()->json([
            'pid' => getmypid(),
            'time' => microtime(true),
        ]);
    });

    // --- 認証必須 ---
    Route::middleware('auth:sanctum')->group(function(){
        // 認証ユーザー情報
        Route::get('/user', UserActionController::class);
        // 認証ユーザーの詳細取得
        Route::get('/users/me', RetrieveActionController::class);
        // ログアウト（アクセストークン無効化）
        Route::post('/users/logout', LogoutActionController::class);

        Route::apiResource('memos', MemoController::class);
    });
});
