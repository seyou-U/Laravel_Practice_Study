<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー一覧（動作確認）</title>
</head>
<body>
    <h1>ユーザー一覧（動作確認）</h1>

    <p>件数：{{ $users->count() }}</p>

    @if ($users->isEmpty())
        <p>ユーザーがありません。</p>
    @else
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
            <th>ID</th>
            <th>名前</th>
            <th>Email</th>
            <th>作成日</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>
