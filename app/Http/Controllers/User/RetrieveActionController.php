<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responder\TokenResponder;
use App\Models\Content;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

        $content = Content::find((int) $id);
        /** @var User $user */
        $user = $this->authManager->guard()->user();
        // canメソッドを用いることで認可処理を実行
        // 第一引数で対応するポリシークラスのメソッド名を記述し、第二引数で第一引数で指定したメソッドで利用するための引数を指定
        if ($user->can('update', $content)) {
            // 実行可能な場合は処理される
        }

        $class = new stdClass;
        // ビルドインインスタンスにidプロパティを与える
        $class->id = 1;
        // ログインユーザーとビルドインインスタンスをポリシークラスのeditに利用している
        $this->gate->forUser(
            $this->authManager->guard()->user()
        )->allows('edit', $class);

        // 以下は上記のコードと同等
        app(AuthorizesRequests::class)->authorizeForUser(
            $this->authManager->guard()->user(),
            'edit',
            $class
        );

        return $this->authManager->guard('jwt')->user();
    }
}
