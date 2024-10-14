<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // attemptメソッドはユーザーの認証試行を行うために使用されるメソッド
        if (Auth::attempt($credentials)) {
            // セッションIDの再発行を行う
            $request->session()->regenerate();

            // intendedメソッドは、ログイン後元々アクセスしようとしていたページに遷移するためのメソッド
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'message' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        // セッションを再生成し、セッションからのデータを削除する(セッションの無効化)
        $request->session()->invalidate();

        // ログアウトした状態でセッション固定攻撃を防ぐ策として、新しいセッショントークンを生成し前のトークンが使用される
        $request->session()->regenerate();

        return redirect('home');
    }
}
