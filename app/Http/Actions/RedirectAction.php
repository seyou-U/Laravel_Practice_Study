<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

// テンプレート出力
final class RedirectAction extends Controller
{
    // ここでは__invokeメソッドで定義しているが、handleメソッドでも良い、単一のメソッドしか呼ばれないことに留意すること
    public function __invoke(Request $request): RedirectResponse
    {
        $response = Response::redirectTo('/');
        $response = $response->redirectTo('/');
        $response = redirect('/');

        // リダイレクト時に様々な動作を行う
        $response = redirect('/')
                ->withInput($request->all())
                ->with('error', 'validation error');

        return $response;
    }
}
