<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ArticlepayloadAction extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $resource = new ArticleResource([
            'id' => 1,
            'title' => 'Laravel REST API',
            'comments' => [
                [
                    'id' => 2134,
                    'body' => 'awesome',
                    'user_id' => 133345,
                    'user_name' => 'Application Developer',
                ]
            ],
            'user_id' => 13255,
            'user_name' => 'User1',
        ]);

        // HATEOASのフォーマットの1つであるHALを適応したレスポンスのため、content-typeで指定する
        return $resource->response($request)
            ->header('content-type', 'application/hal+json');
    }
}
