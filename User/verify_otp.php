<?php
session_start();

// POSTリクエストが送信された場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ユーザーが入力したOTPを取得
    $input_otp = $_POST['otp'];

    // セッションに保存されているOTPと比較
    if (isset($_SESSION['otp'])) {
        $stored_otp = $_SESSION['otp'];
        $otp_time = $_SESSION['otp_time'];

        // OTPの有効期限を設定（例えば、5分間）
        $otp_expiry_time = 5 * 60; // 5分 = 300秒
        if ((time() - $otp_time) > $otp_expiry_time) {
            // OTPが期限切れの場合
            $error_message = "ワンタイムパスワードの有効期限が切れました。再度メールを送信してください。";
        } elseif ($input_otp == $stored_otp) {
            // OTPが一致した場合
            $_SESSION['otp_verified'] = true;
            header("Location: change_password.php"); // パスワード再設定フォームにリダイレクト
            exit();
        } else {
            // OTPが一致しない場合
            $error_message = "入力されたワンタイムパスワードが無効です。再度確認してください。";
        }
    } else {
        // セッションにOTPが保存されていない場合
        $error_message = "OTPが存在しません。再度メールを送信してください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="change_password_email.css">
    <title>ワンタイムパスワード認証</title>
</head>
<body class="content">
    <h1>ワンタイムパスワード認証</h1>

    <?php
    // エラーメッセージを表示
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>

    <form action="" method="post">
        <label for="otp">OTP（メールに記載されたコード）:</label>
        <input type="text" id="otp" name="otp" required>
        <button type="submit">認証する</button>
    </form>

    <p>コードが届いていない場合、<a href="resend_otp.php">再送信</a>してください。</p>
</body>
</html>
