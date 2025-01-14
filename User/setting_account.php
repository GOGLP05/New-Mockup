<?php
// セッション開始
session_start();

// ログインしていない場合は、ログインページにリダイレクト
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit;
}

// セッションからユーザー情報を取得
$member_id = $_SESSION['member_id'];
$email = $_SESSION['email'];
$sex = $_SESSION['sex'];
$birthdate = $_SESSION['birthdate'];
$message = $_SESSION['message'];

$errs = [];

// パスワード変更フォームの処理（省略）
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // パスワード変更の処理
    // ここにパスワード変更処理を追加します
    // バリデーションやパスワード変更のロジック
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="setting_account.css">
    <title>アカウント設定</title>
    <script>
        function confirmLogout() {
            // 確認ダイアログを表示
            if (confirm("ログアウトしますか？")) {
                // "OK"が押された場合はログアウトページへ遷移
                window.location.href = 'login.php';
            }
        }
    </script>
</head>
<body>
    <div class="hamburger-menu">
        <input id="menu__toggle" type="checkbox" />
        <label class="menu__btn" for="menu__toggle">
            <span></span>
        </label>

        <ul class="menu__box">
            <li><a class="menu__item" href="top.php">TOP</a></li>
            <li><a class="menu__item" href="list_of_food.php">食品庫</a></li>
            <li><a class="menu__item" href="food_registration.php">食品登録</a></li>
            <li><a class="menu__item" href="setting.php">設定</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>アカウント設定</h1>
        
        <?php if (!empty($errs)): ?>
            <div class="errors">
                <?php foreach ($errs as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="sub_content">
            <p><strong>メールアドレス:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>性別:</strong> <?php echo $sex == 1 ? '男性' : '女性'; ?></p>
            <p><strong>生年月日:</strong> <?php echo htmlspecialchars($birthdate, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- パスワード変更フォーム -->
        <form action="" method="POST">
            <input type="button" class="sub_content" onclick="location.href='loged_in_change_password.php'" value="パスワードの変更">
        </form>

        <div class="bottom">
            <input type="button" class="sub_content" onclick="history.back()" value="戻る">
            <input type="button" class="sub_content" onclick="confirmLogout()" value="ログアウト">
        </div>
    </div>
</body>
</html>
