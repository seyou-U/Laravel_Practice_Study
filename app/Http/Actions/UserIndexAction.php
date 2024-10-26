<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Http\Responder\UserResponder;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class UserIndexActions extends Controller
{
    private $domain;
    private $userResponder;

    public function __construct(UserService $userService, UserResponder $userResponder)
    {
        $this->domain = $userService;
        $this->userResponder = $userResponder;
    }

    // ここでは__invokeメソッドで定義しているが、handleメソッドでも良い、単一のメソッドした呼ばれないことに留意すること
    public function __invoke(Request $request): Response
    {
        return $this->userResponder->response(
            $this->domain->retrieveUser($request->get('id'))
        );
    }
}
