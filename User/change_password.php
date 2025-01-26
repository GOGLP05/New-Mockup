<?php
session_start();

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    // OTP認証がされていない場合はリダイレクト
    header('Location: otp_verification.php');
    exit();
}

// エラーメッセージを格納する配列
$errs = [];

// POSTリクエストが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // パスワードの入力チェック
    if ($new_password === '') {
        $errs[] = '新しいパスワードを入力してください';
    }

    if ($confirm_password === '') {
        $errs[] = '新しいパスワード（確認用）を入力してください';
    }

    if ($new_password !== $confirm_password) {
        $errs[] = '新しいパスワードと確認用パスワードが一致しません';
    }

    // エラーがなければパスワードを更新
    if (empty($errs)) {
        try {
            // セッションからメールアドレスを取得
            $email = $_SESSION['email'];

            // MemberDAOインスタンスを作成
            require_once 'helpers/MemberDAO.php';
            $memberDAO = new MemberDAO();

            // メンバーの情報を取得
            $member = $memberDAO->get_member_by_email($email);

            if ($member) {
                // 新しいパスワードをハッシュ化
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // パスワードをデータベースに保存
                $isPasswordChanged = $memberDAO->update_password_by_email($email, $hashed_password);

                if ($isPasswordChanged) {
                    // パスワード変更成功
                    echo "<script type='text/javascript'>
                        alert('パスワードが変更されました');
                        window.location.href = 'login.php'; // ログインページにリダイレクト
                    </script>";
                    exit();
                } else {
                    $errs[] = 'パスワードの変更に失敗しました。もう一度お試しください。';
                }
            } else {
                $errs[] = '該当するユーザーが見つかりませんでした。';
            }
        } catch (Exception $e) {
            $errs[] = 'システムエラーが発生しました。';
            error_log($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="change_password_email.css">
</head>
<body>

    <h1>パスワード再設定</h1>

    <div class="container">
        <?php if (!empty($errs)): ?>
            <div class="errors">
                <?php foreach ($errs as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="new_password">新しいパスワード</label>
            <input type="password" id="new_password" name="new_password" placeholder="新しいパスワードを入力してください" required>

            <label for="confirm_password">新しいパスワード（確認用）</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="新しいパスワードをもう一度入力してください" required>

            <button type="submit">変更</button>
        </form>
    </div>

</body>
</html>
