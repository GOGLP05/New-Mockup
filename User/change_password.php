<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    // パスワードの処理（例えば、データベースに保存する等）
    // ここでパスワードを処理した後、リダイレクトなどが可能です。
    // header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>
    <link rel="stylesheet" href="change_password.css">
</head>
<body>

    <h1>パスワード設定</h1>
    <div class="container">
        <form action="" method="POST">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" placeholder="パスワードを入力してください。">
            <button type="submit">送信</button>
        </form>
    </div>

</body>
</html>
