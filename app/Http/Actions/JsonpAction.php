<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

// JSONPレスポンス
final class JsonpAction extends Controller
{
    public function __invoke(): JsonResponse
    {
        $response = Response::jsonp('callback', ['status' => 'success']);

        // ヘルパー関数を利用する場合
        $response = response()->jsonp('callback', ['status' => 'success']);

        return $response;
    }
}
