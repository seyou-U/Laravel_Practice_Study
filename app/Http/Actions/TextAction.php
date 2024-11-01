<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Response;

// 文字列出力
final class TextAction extends Controller
{
    // ここでは__invokeメソッドで定義しているが、handleメソッドでも良い、単一のメソッドしか呼ばれないことに留意すること
    public function __invoke(): IlluminateResponse
    {
        $response = Response::make('Hello world');
        // ヘルパー関数を使用する場合
        $response = response('Hello world');

        // content-typeを変更
        $response = response(
            'Hello world',
            // IlluminateResponse::HTTP_OKと同等
            200,
            [
                'content-type' => 'text/plain'
            ]
        );

        return $response;
    }
}
