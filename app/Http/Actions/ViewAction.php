<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Response;

// テンプレート出力
final class ViewAction extends Controller
{
    // ここでは__invokeメソッドで定義しているが、handleメソッドでも良い、単一のメソッドしか呼ばれないことに留意すること
    public function __invoke(): IlluminateResponse
    {
        $response = Response::view('view.file');
        // 上記と同様の結果を得ることができる
        $response = view('view.file');

        // ステータスコードを変更し、ビューを出力する
        $response = response(view('view.file'), 200);

        return $response;
    }
}
