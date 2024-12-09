<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="change_password.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>

</head>

<body>

    <h1>パスワード取得メール</h1>
    <div class="container">
        <label for="user_id">メールアドレス</label>
        <input type="text" id="user_id" name="user_id"
            placeholder="メールアドレスを入力してください。">

        <a href="change_password.php"><button onclick="PasswordSettei.php">メールを送信</button></a>
    </div>
    <script>
        function login() {
            var user_id = document.getElementById('user_id').value;
            if (user_id === "") {
                alert("メールアドレスを入力してください。");
            } else {
                alert(PasswordSai3.html());
            }
        }
    </script>

</body>

</html>