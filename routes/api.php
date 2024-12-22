<?php

use App\Http\Actions\PublisherAction;
use App\Http\Controllers\User\LoginActionController;
use App\Http\Controllers\UserActionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/user', UserActionController::class);

Route::post('/publishers', [PublisherAction::class, 'create']);

Route::group(['middleware' => 'api'], function () {
    // ログインを行い、アクセストークンを発行する
    Route::post('/users/login', LoginActionController::class);
    // アクセストークンを用いて、認証ユーザーの情報を取得する
    // Route::post('/users/', RetrieveAction::class)
    //     ->middleware('auth:jwt');
});
