<?php
require_once 'helpers/MemberDAO.php';

session_start();

// ログインしていない場合は、ログインページにリダイレクト
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit;
}

// ログイン中のユーザーのIDを取得
$member_id = $_SESSION['member_id'];
$errs = [];

// POSTリクエストが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['password']; // 旧パスワード
    $new_password = $_POST['password1']; // 新パスワード

    // 入力チェック
    if ($user_id === '') {
        $errs[] = 'メールアドレスを入力してください';
    }

    if ($old_password === '') {
        $errs[] = '現在のパスワードを入力してください';
    }

    if ($new_password === '') {
        $errs[] = '新しいパスワードを入力してください';
    }

    if (empty($errs)) {
        try {
            $memberDAO = new MemberDAO();
            // メンバー情報を取得
            $member = $memberDAO->get_member_by_id($member_id);

            // 現在のパスワードが一致するか確認
            if (password_verify($old_password, $member->password)) {
                // 新しいパスワードをハッシュ化
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // パスワードを更新
                $isPasswordChanged = $memberDAO->update_password($member_id, $hashed_password);

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
                $errs[] = '現在のパスワードが間違っています。';
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
    <title>パスワード変更</title>
    <link rel="stylesheet" href="loged_in_change_password.css">
</head>
<body>

    <h1>パスワード変更</h1>

    <div class="container">
        <?php if (!empty($errs)): ?>
            <div class="errors">
                <?php foreach ($errs as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="user_id">メールアドレス</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?>" readonly>

            <label for="password">現在のパスワード</label>
            <input type="password" id="password" name="password" placeholder="現在のパスワードを入力してください" required>

            <label for="password1">新しいパスワード</label>
            <input type="password" id="password1" name="password1" placeholder="新しいパスワードを入力してください" required>

            <button type="submit">変更</button>
        </form>
    </div>

</body>
</html>
