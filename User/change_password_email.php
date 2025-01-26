<?php
require_once 'helpers/MemberDAO.php';
$memberDAO = new MemberDAO();
$member_emails = $memberDAO->get_member_email();

// フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力されたメールアドレスを取得
    $input_email = $_POST['email'];

    // メールアドレスがリストに存在するかチェック
    $email_exists = false;
    foreach ($member_emails as $member) {
        if ($member->email === $input_email) {
            $email_exists = true;
            break;
        }
    }

    if ($email_exists) {
        // メールアドレスが存在した場合、そのまま送信（リダイレクト）
        header('Location: helpers/send_otp.php?email=' . urlencode($input_email));
        exit(); // 必ずスクリプトを終了する
    } else {
        // メールアドレスが見つからなかった場合、エラーメッセージを表示
        $error_message = 'このメールアドレスは登録されていません。<br><a href="member_registration.php">会員登録はこちらから</a>';
    }
} else {
    // フォームが最初に表示されたときはactionをデフォルトに設定
    $form_action = ''; // 最初は空にする
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="change_password_email.css">
    <title>パスワード再設定 - メールアドレス入力</title>
</head>
<body class="content">
    <h1>パスワード再設定</h1>
    
    <?php
    // エラーメッセージを表示
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
    
    <form action="" method="post">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">送信</button>
    </form>
</body>
</html>
