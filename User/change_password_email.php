<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定 - メールアドレス入力</title>
</head>
<body>
    <h1>パスワード再設定</h1>
    <form action="helpers/send_otp.php" method="post">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">送信</button>
    </form>
</body>
</html>
