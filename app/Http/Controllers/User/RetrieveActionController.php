<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RetrieveActionController extends Controller
{
    // ミドルウェアauth:sanctumが通ったのちに呼ばれる
    public function __invoke(Request $request): JsonResponse
    {
        // ミドルウェアauth:sanctumが通っているのでユーザー情報をそのまま返す
        return response()->json($request->user());
    }
}
