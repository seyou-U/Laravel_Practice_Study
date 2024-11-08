<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>トップ画面</title>
</head>
<body>
    <p>こんにちは
    @if (Auth::check())
        {{ \Auth::user()->name }}さん</p>
        <p><a href="{{ route('logout')}}">ログアウト</a></p>
    @else
        ゲストさん</p>
        <p><a href="{{ route('login') }}">ログイン</a></br><a href="{{ route('create') }}">会員登録</a></p>
    @endif
    <form method="post" action="{{ route('try') }}">
        @csrf
        <input type="submit" value="storeアクションの動作確認ボタン">
    </form>
</body>
</html>
