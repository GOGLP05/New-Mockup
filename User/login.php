<?php
session_start();

// データベース接続設定
$host = "";
$dbname = ""; // データベース名
$username = ""; // データベースのユーザー名
$password = ""; // データベースのパスワード

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["user_id"];
    $user_password = $_POST["password"];
    
    //サニタイジング
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($user_password, $user['password'])) {
        // パスワードが一致する場合
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: top.php"); // ログイン後のページにリダイレクト
        exit;
    } else {
        
        $error_message = "メールアドレスまたはパスワードが間違っています。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h1>ログイン</h1>

    <form action="login.php" method="POST">
        <div class="container">
            <label for="user_id">メールアドレス</label>
            <input type="text" id="user_id" name="user_id" placeholder="メールアドレスを入力してください">

            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" placeholder="パスワードを入力してください">

            <input type="submit" value="ログイン">
        </div>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <p><a class="links" href="change_password_email.html">パスワードを忘れた方はこちら</a></p>
        <p><a class="links" href="member_registration.html">会員登録はこちら</a></p>
    </form>
</body>
</html>
