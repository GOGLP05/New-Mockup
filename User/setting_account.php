<?php
session_start();

$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'guest@example.com';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="setting_account.css">
    <title>設定</title>
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
        <h1>アカウント</h1>
        <div class="sub_content">
            <p>メールアドレス: <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <input type="button" class="sub_content" onclick="location.href='loged_in_change_password.php'" value="パスワードの変更">
        <div class="bottom">
            <input type="button" class="sub_content" onclick="history.back()" value="戻る">
            <input type="button" class="sub_content" onclick="location.href='login.php'" value="ログアウト">
        </div>
    </div>
</body>
</html>