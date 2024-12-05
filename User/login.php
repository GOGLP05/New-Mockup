

<?php
/*
session_start();

$host = "10.32.97.1/sotu";
$dbname = "UserTable";
$username = "23jn03_G5";
$password = "23jn03_G5";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続失敗: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["admin_id"];
    $user_password = $_POST["password"];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($user_password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: top.php"); 
        exit;
    } else {
        $error_message = "メールアドレスまたはパスワードが間違っています。";
    }
}
    */
?>



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