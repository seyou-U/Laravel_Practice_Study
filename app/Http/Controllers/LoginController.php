<?php

namespace App\Http\Controllers;

use App\Class\Complex;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        // 解決方法について以下の2通りがある (makeメソッドもしくはappヘルパー)
        app()->make(Complex::class)->setup();
        app(Complex::class)->setup();

        // bindが定義されていないクラスのインスタンス生成とパラメータの受け渡しを確認
        // dd(app(Unbinding::class, ['name' => 'test']));
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
