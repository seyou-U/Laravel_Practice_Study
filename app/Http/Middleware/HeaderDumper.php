<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class HeaderDumper
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * リクエストヘッダをログに書き起こす
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // strvalはstring型として値を返却する
        // リクエストヘッダを取得する
        $this->logger->info(
            'request',
            [
                'header' => strval($request->headers)
            ]
        );

        // コントローラのアクションが実行された結果が返却される
        return $next($request);

        // レスポンスヘッダの取得
        // $response = $next($request);
        // $this->logger->info(
        //     'response',
        //     [
        //         'header' => strval($response->headers)
        //     ]
        // );

        // return $response;
    }
}
