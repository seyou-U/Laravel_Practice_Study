<?php

use App\Http\Actions\PublisherAction;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\UserActionController;
use App\Http\Controllers\User\LoginActionController;
use App\Http\Controllers\User\RetrieveActionController;
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
});

Route::resource('memos', MemoController::class);
