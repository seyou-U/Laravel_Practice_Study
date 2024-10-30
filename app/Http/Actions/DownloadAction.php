<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// ダウンロードレスポンス
final class DownloadAction extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $response = Response::download('/path/to/file.pdf');

        $response = response()->download('/path/to/file.pdf');

        // ファイル名を指定してDLする場合は、第二、第三引数に対し任意の指定を行う
        $response = response()->download(
            '/path/to/file.pdf',
            'filename.pdf',
            [
                'content-type' => 'application/pdf',
            ]
        );

        return $response;
    }
}
