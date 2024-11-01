<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

// SSEの実装例
final class StreamAction extends Controller
{
    // ここでは__invokeメソッドで定義しているが、handleメソッドでも良い、単一のメソッドしか呼ばれないことに留意すること
    public function __invoke(): StreamedResponse
    {
        return response()->stream(
            function () {
                while (true) {
                    echo 'data: ' . rand(1, 100) . "\n\n";
                    // 出力バッファの内容を送信する
                    ob_flush();
                    //
                    flush();
                    // マイクロ秒で処理を遅延させる
                    usleep(200000);
                }
            },
            200,
            [
                'content-type' => 'text/event-stream',
                'X-Accel-Buffering' => 'no',
                'Cache-Control' => 'no-cache',
            ]
        );
    }
}
