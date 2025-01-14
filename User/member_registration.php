<?php
require_once 'helpers/MemberDAO.php'; // MemberDAOを読み込む

$errs = [];
$user_id = '';
$password = '';
$sex = '';
$date = '';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // フォームデータを受け取る
    $user_id = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $date = $_POST['date'] ?? '';

    // バリデーション
    if ($user_id === '') {
        $errs[] = 'メールアドレスを入力してください';
    } elseif (!filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
        $errs[] = 'メールアドレスの形式に誤りがあります';
    }

    if ($password === '') {
        $errs[] = 'パスワードを入力してください';
    }

    if ($sex === '') {
        $errs[] = '性別を選択してください';
    } else {
        // 性別を数値に変換（1: 男性, 0: 女性）
        $sex = ($sex === 'male') ? 1 : 0;
    }

    if ($date === '') {
        $errs[] = '生年月日を入力してください';
    }

    // メールアドレスが既に登録されていないか確認
    if (empty($errs)) {
        $memberDAO = new MemberDAO();
        if ($memberDAO->email_exists($user_id)) {
            $errs[] = 'このメールアドレスは既に登録されています';
        }
    }

    // エラーがない場合、データベースに保存
    if (empty($errs)) {
        try {
            // パスワードをハッシュ化
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 会員情報をデータベースに登録
            $memberDAO = new MemberDAO();
            if ($memberDAO->create_member($user_id, $hashedPassword, $sex, $date)) {
                header('Location: login.php'); // 登録後はログインページへリダイレクト
                exit;
            } else {
                $errs[] = '登録に失敗しました。もう一度お試しください。';
            }
        } catch (Exception $e) {
            $errs[] = 'システムエラーが発生しました。';
            error_log($e->getMessage()); // エラー詳細をログに記録
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="member_registration.css">
    <title>会員登録</title>
</head>
<body>
    <h1>会員登録フォーム</h1>
    <?php if (!empty($errs)): ?>
        <div class="errors">
            <?php foreach ($errs as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="container">
            <label for="user_id">メールアドレス</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="password">パスワード</label>
            <input type="password" id="password" name="password">

            <label>性別</label>
            <label><input type="radio" name="sex" value="male" <?php if ($sex === 1) echo 'checked'; ?>> 男</label>
            <label><input type="radio" name="sex" value="female" <?php if ($sex === 0) echo 'checked'; ?>> 女</label>

            <label for="date">生年月日</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">

            <input type="submit" value="登録">
            <p><a href="login.php">ログインページへ戻る</a></p>
        </div>
    </form>
</body>
</html>
