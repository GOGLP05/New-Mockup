<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composerのオートロードを読み込む

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = rand(100000, 999999);

    $mail = new PHPMailer(true);

    try {
        // SMTP設定
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // GmailのSMTPサーバー
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // 送信元のGmailアドレス
        $mail->Password = 'your-email-password'; // Gmailのアプリパスワード
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // メールの内容
        $mail->setFrom('no-reply@example.com', 'No Reply');
        $mail->addAddress($email); // 送信先のメールアドレス
        $mail->isHTML(true);
        $mail->Subject = 'パスワード再設定のためのOTP';
        $mail->Body = "あなたのOTPは <b>$otp</b> です。このコードをパスワード再設定画面で入力してください。";

        $mail->send();
        echo "メールを送信しました。メールに記載されたOTPを入力してください。";
    } catch (Exception $e) {
        echo "メールの送信に失敗しました。エラー: {$mail->ErrorInfo}";
    }
}
?>