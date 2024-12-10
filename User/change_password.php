<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $result = "";

    if (isset($_POST['post'])) {
        $result = "登録しました";
        echo "<script>
                alert('パスワードが変更されました。');
                window.location.href = 'login.php';
            </script>";
        exit;
    }
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
        <form action="change_password.php" method="POST">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" placeholder="パスワードを入力してください。">
            <button type="submit" name="post">送信</button>
        </form>
    </div>

</body>
</html>
