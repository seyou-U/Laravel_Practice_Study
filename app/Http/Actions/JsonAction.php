<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

// JSONレスポンス
final class JsonAction extends Controller
{
    public function __invoke(): JsonResponse
    {
        $response = Response::json(['status' => 'success']);

        // ヘルパー関数を利用する場合
        $response = response()->json(['status' => 'success']);

        return $response;
    }
}
