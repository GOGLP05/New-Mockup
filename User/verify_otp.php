<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定 - OTP入力</title>
</head>
<body>
    <h1>ワンタイムパスコード認証</h1>
    <form action="reset_password.php" method="post">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="otp">ワンタイムパスコード:</label>
        <input type="text" id="otp" name="otp" required>
        
        <button type="submit">送信</button>
    </form>
</body>
</html>
