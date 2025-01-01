<?php

namespace App\Foundation\ViewComposer;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\View\View;

final class PolicyComposer
{
    private $gate;
    private $authManager;

    public function __construct(Gate $gate, AuthManager $authManager)
    {
        $this->gate = $gate;
        $this->authManager = $authManager;
    }

    public function compose(View $view)
    {
        $allow = $this->gate->forUser(
            $this->authManager->guard()->user()
        )->allows('edit');

        // 認可されてる場合はbladeのyieldディレクティブに指定されているauthorizedにallowedを表示する
        if ($allow) {
            $view->getFactory()->inject('authorized', 'allowed');
        }
        $view->getFactory()->inject('authorized', 'denied');
    }

}
