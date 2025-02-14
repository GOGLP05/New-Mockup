<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composerのオートロードを読み込む

// PHP部分：処理の実行
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "無効なメールアドレスです。";
    } else {
        $otp = rand(100000, 999999);

        // OTPをセッションに保存
        session_start();
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_time'] = time(); // OTPの有効期限を設定

        $mail = new PHPMailer(true);
        try {
            // SMTP設定
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // GmailのSMTPサーバー
            $mail->SMTPAuth = true;
            $mail->Username = 'sample@jec.ac.jp'; // 送信元メアド。スパム回避のため、ダミーメアド
            $mail->Password = 'fdag ebxw hayx ipwd'; // 環境変数からパスワードを取得
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // 文字エンコーディングをUTF-8に設定
            $mail->CharSet = 'UTF-8';

            // メールの内容
            $mail->setFrom('23jn0344@jec.ac.jp', 'No Reply');
            $mail->addAddress($email); // 送信先のメールアドレス
            $mail->isHTML(true);
            $mail->Subject = "パスワード再設定のためのワンタイムパスワード";  // 日本語の件名
            $mail->Body = "あなたのワンタイムパスワードは <b>$otp</b> です。このコードをワンタイムパスワード認証画面で入力してください。";

            $mail->send();
            $successMessage = "メールを送信しました。メールに記載されたワンタイムパスワードを次の画面で入力してください。5秒後に認証画面にリダイレクトされます。";
        } catch (Exception $e) {
            error_log("メールの送信に失敗しました。エラー: {$mail->ErrorInfo}");
            $errorMessage = "メールの送信に失敗しました。しばらくしてから再度お試しください。";
        }
    }
} else {
    $errorMessage = "メールアドレスが指定されていません。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP送信</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #5c6bc0;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin: 15px 0;
        }
        .message {
            padding: 20px;
            background-color: #e8f5e9;
            border-left: 5px solid #4caf50;
            margin-bottom: 20px;
        }
        .error {
            padding: 20px;
            background-color: #ffebee;
            border-left: 5px solid #f44336;
            margin-bottom: 20px;
        }
        .redirect {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($errorMessage)): ?>
            <div class="error">
                <p><?php echo $errorMessage; ?></p>
            </div>
        <?php elseif (isset($successMessage)): ?>
            <div class="message">
                <p><?php echo $successMessage; ?></p>
            </div>
            <script type="text/javascript">
                setTimeout(function() {
                    window.location.href = "../verify_otp.php";
                }, 5000);
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
