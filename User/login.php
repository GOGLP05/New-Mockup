




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ログイン</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <h1>ログイン</h1>  
    </head>
    <body>
        <form action="" method="POST">
            <table>
            <div class="container">
                <label for="user_id">メールアドレス</label>
                <input type="text" id="user_id" name="admin_id" 
                placeholder="メールアドレスを入力してください">

                <label for="password">パスワード</label>
                <input type="password" id="password" name="password"
                placeholder="パスワードを入力してください">

                <input type="button" onclick="location.href='top.php'" value="ログイン">


                <p><a class="links" href="change_password_email.php">パスワードを忘れた方はこちら</a></p>

                <p><a class="links" href="member_registration.php">会員登録はこちら</a></p>
            </div>
        </form>
        </body>
        </html>