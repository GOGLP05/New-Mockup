<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_login.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
</head>
<body>

    <h1>管理者ログイン</h1>

    <div class="container">
        <label for="userid">管理者ID:</label>
        <input type="text" id="kanrisyaid" name="kanrisyaid" placeholder="管理者IDを入力">

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" placeholder="パスワードを入力">

        <button onclick="login()">ログイン</button>
    </div>

    <script>
        function login() {
            var kanrisyaid = document.getElementById('kanrisyaid').value;
            var password = document.getElementById('password').value;

            // 入力値が空でないかチェック
            if(kanrisyaid === "" || password === "") {
                alert("管理者IDとパスワードを入力してください。");   
            } else {
                window.location.href = 'admin_top.php';
            }
        }
    </script>

</body>
</html>