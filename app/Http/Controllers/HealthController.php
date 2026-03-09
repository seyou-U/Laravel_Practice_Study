<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class HealthController extends Controller
{
    #[OA\Get(
        path: '/api/health',
        summary: '疎通確認',
        tags: ['Health'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'ok', type: 'boolean', example: true),
                    ]
                )
            ),
        ]
    )]
    public function __invoke(): JsonResponse
    {
        return response()->json(['ok' => true]);
    }
}
