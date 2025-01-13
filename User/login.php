<?php
require_once 'helpers/MemberDAO.php';

$email = '';
$errs = [];

session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 入力のバリデーション
    if ($email === '') {
        $errs[] = 'メールアドレスを入力してください';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errs[] = 'メールアドレスの形式に誤りがあります';
    }

    if ($password === '') {
        $errs[] = 'パスワードを入力してください';
    }

    if (empty($errs)) {
        try {
            $memberDAO = new MemberDAO();
            $member = $memberDAO->get_member($email, $password);

            if ($member !== false) {
                session_regenerate_id(true);

                // 会員情報を個別にセッションに保存
                $_SESSION['member_id'] = $member->member_id;
                $_SESSION['email'] = $member->email;
                $_SESSION['password'] = $member->password; // ハッシュ化されたパスワード
                $_SESSION['sex'] = $member->sex;
                $_SESSION['birthdate'] = $member->birthdate;
                $_SESSION['message'] = $member->message;

                // ログイン後にTOPページへリダイレクト
                header('Location: top.php');
                exit;
            } else {
                $errs[] = 'メールアドレスまたはパスワードに誤りがあります。';
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h1>ログイン</h1>
    <?php if (!empty($errs)): ?>
        <div class="errors">
            <?php foreach ($errs as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="container">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" placeholder="メールアドレスを入力してください" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="password">パスワード</label>
            <input type="password" name="password" placeholder="パスワードを入力してください" required>

            <input type="submit" value="ログイン">

            <p><a class="links" href="change_password_email.php">パスワードを忘れた方はこちら</a></p>
            <p><a class="links" href="member_registration.php">会員登録はこちら</a></p>
        </div>
    </form>
</body>
</html>
