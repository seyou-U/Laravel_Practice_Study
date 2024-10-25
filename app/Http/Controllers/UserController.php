<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class UserController extends Controller
{
    public function show(Request $request): View
    {
        $user = User::find($request->get('id'));

        return view('user.show', compact('user'));
    }

    public function store(Request $request): RedirectResponse
    {
        // 登録処理など
    }
}
