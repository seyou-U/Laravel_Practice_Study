<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserPurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserPurchaseService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request): View
    {
        $result =  $this->service->retrievePurchase($request->get('id'));

        return view('user.show', compact('result'));
    }

    public function store(Request $request): RedirectResponse
    {
        // 登録処理など
    }
}
