<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
}
$alert = "<script type='text/javascript'>
alert('パスワードが変更されました');</script>";
echo $alert;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>
    <link rel="stylesheet" href="loged_in_change_password.css">
</head>
<body>

    <h1>パスワード変更</h1>

    <div class="container">
        <form action="" method="POST">
            <label for="user_id">メールアドレス</label>
            <input type="text" id="user_id" name="user_id" placeholder="メールアドレスを入力してください。">

            <label for="password">旧パスワード</label>
            <input type="password" id="password" name="password" placeholder="今のパスワードを入力してください">

            <label for="password1">新パスワード</label>
            <input type="password" id="password1" name="password1" placeholder="新しいパスワードを入力してください">

            <button type="submit">変更</button>
        </form>
    </div>

</body>
</html>
