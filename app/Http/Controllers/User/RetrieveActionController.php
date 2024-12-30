<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responder\TokenResponder;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RetrieveActionController extends Controller
{
    private $authManager;
    private $gate;

    public function __construct(AuthManager $authManager, Gate $gate)
    {
        $this->authManager = $authManager;
        $this->gate = $gate;
    }

    public function __invoke(string $id)
    {
        // AuthServiceProvideクラスのdefineメソッドで記述した処理が実行される
        if ($this->gate->allows('user-access', $id)) {
            // 実行が許可される場合に実行
        }

        return $this->authManager->guard('jwt')->user();
    }
}
