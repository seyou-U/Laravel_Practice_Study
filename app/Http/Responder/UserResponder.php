<?php

// 暗黙の型変換を禁止し、型の指定を厳密にチェックする
declare(strict_types=1);

namespace App\Http\Responder;

use App\Models\User as UserModel;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Response;

class UserResponder
{
    private $response;
    private $view;

    public function __construct(Response $response, ViewFactory $viewFactory)
    {
        $this->response = $response;
        $this->view = $viewFactory;
    }

    public function response(UserModel $user): Response
    {
        if (empty($user->id)) {
            $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $this->response->setContent(
            $this->view->make('user.show', compact('user'))
        );

        // MVCパターンではviewを返却していたが、ADRパターンではレスポンスを返却する
        return $this->response;
    }

    // 上記のresponseメソッドについてヘルパ関数を用いた記述方法について下記に書いてみる
    // public function response(UserModel $user): Response
    // {
    //     $statusCode = Response::HTTP_OK;
    //     if (empty($user->id)) {
    //         $statusCode = Response::HTTP_NOT_FOUND;
    //     }

    //     return response('user.show', $statusCode, compact('user'));
    // }
}
