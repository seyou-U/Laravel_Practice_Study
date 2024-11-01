<?php

use App\Http\Actions\ArticlepayloadAction;
use App\Http\Actions\JsonAction;
use App\Http\Actions\JsonpAction;
use App\Http\Actions\StreamAction;
use App\Http\Actions\TextAction;
use App\Http\Actions\UserIndexActions;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// クロージャーを実行する書き方
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/create', [RegisterController::class, 'create'])->name('create');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        // Route::post('people', [RegisterController::class, 'store']);
});

Route::resource('users', UserController::class)->only([
    'show', 'store'
]);

// ADRパターンのルーティング定義
// Route::get('users', UserIndexAction::class);
Route::get('text', TextAction::class);
Route::get('json', JsonAction::class);
Route::get('jsonp', JsonpAction::class);
Route::get('stream', StreamAction::class);

// HALを適応したJSONを返却する
Route::get('/payload', ArticlepayloadAction::class);


//  コントローラーのクラスのみを指定した場合、AddTaskActionの__invokeメソッドを実行する
// Route::post('/tasks', 'AddTaskAction::class');
