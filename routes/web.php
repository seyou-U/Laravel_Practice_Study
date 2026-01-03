<?php

use App\Events\PublishProcessor;
use App\Http\Actions\ArticlepayloadAction;
use App\Http\Actions\JsonAction;
use App\Http\Actions\JsonpAction;
use App\Http\Actions\StreamAction;
use App\Http\Actions\TextAction;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfGeneratorAction;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\HeaderDumper;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Dispatcherクラス経由でEventを実行する場合
    Event::dispatch(new PublishProcessor(1));
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->middleware(HeaderDumper::class)->name('headerDumper');
Route::post('try', [HomeController::class, 'store'])->name('try');

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

Route::get('/pdf', PdfGeneratorAction::class);
