<?php

namespace App\Http\Responder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TokenResponder
{
    public function __invoke($token, int $ttl): JsonResponse
    {
        if (empty($token)) {
            return response()->json([
                'error' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl,
        ], Response::HTTP_OK);
    }
}
