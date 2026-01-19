<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>お問い合わせ</title>
</head>
<body>
    <h1>お問い合わせ</h1>

    @if (session('status'))
        <p style="color: green">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    @endif

    <form method="POST" action="/contact">
        @csrf

        <div>
        <label>お名前</label><br>
        <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
        <label>メールアドレス</label><br>
        <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <button type="submit">送信</button>
    </form>
</body>
</html>
