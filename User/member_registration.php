<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="member_registration.css">
        <title>会員登録</title>
        
    </head>
    <body>
        <h1>会員登録フォーム</h1>
        <form action="" method="POST">
            <div class="container">
                <label for="user_id">メールアドレス</label>
                <input type="text" id="user_id" name="user_id">
                
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">
                
                <label>性別</label>
                <label><input type="radio" name="sex" value="male"> 男</label>
                <label><input type="radio" name="sex" value="female"> 女</label>
                
                <label for="date">生年月日</label>
                <input type="date" id="date" name="date">
                
                <input type="button" onclick="location.href='login.php'" value="登録">
            </div>
        </form>
    </body>
</html>
