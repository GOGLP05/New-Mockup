<?php
require_once 'helpers/MemberDAO.php';

session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'guest@example.com';

// メッセージの状態を初期化
$notification = 0;  // デフォルトはオフ(0)

// データベースからnotificationの状態を取得して初期化
try {
    $memberDAO = new MemberDAO();
    $notification = $memberDAO->get_notification($email); // get_notificationメソッドでDBから状態を取得
} catch (Exception $e) {
    // エラーハンドリング (例: ログに記録)
    echo "<script>alert('通知設定の取得に失敗しました');</script>";
    echo($e->getMessage());
}

// POSTリクエストが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // トグルスイッチの状態が送信された場合
    if (isset($_POST['toggleSwitch'])) {
        // スイッチがオンの場合、notificationを1に設定
        $notification = 1;
    } else {
        // スイッチがオフの場合、notificationを0に設定
        $notification = 0;
    }

    // DAOを使ってnotificationの状態をデータベースに保存
    try {
        $result = $memberDAO->update_notification($email, $notification);

        if ($result) {
            echo "<script>alert('通知設定が保存されました');</script>";
        } else {
            echo "<script>alert('通知設定の保存に失敗しました');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('エラーが発生しました');</script>";
        echo($e->getMessage()); // エラーログを記録
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="common.css">
  <link rel="stylesheet" href="setting.css">
  <title>設定</title>
  <script>
    // トグルが変更された時にフォームを送信
    function toggleChange() {
        // フォームを送信
        document.getElementById('notificationForm').submit();
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
      <li><a class="menu__item" href="recipe_list.php">レシピ一覧</a></li>
      <li><a class="menu__item" href="food_registration.php">食品登録</a></li>
      <li><a class="menu__item" href="setting.php">設定</a></li>
    </ul>
  </div>

  <div class="content">
    <h1>設定</h1>
    <input type="button" class="sub_content" onclick="location.href='setting_account.php'" value="アカウント">
    <div class="notification">
      <div class="notification-button">
        <input type="button" class="sub_content" onclick="" value="通知">
      </div>
    </div>

    <div class="notification">
      <!-- フォームのIDを設定し、submitボタンとしてトグルを利用 -->
      <form method="post" action="" class="notification-form" id="notificationForm">
        <label class="switch">
          <input type="checkbox" id="toggleSwitch" name="toggleSwitch" onchange="toggleChange()" <?php if ($notification == 1) echo 'checked'; ?>>
          <span class="slider round"></span>
        </label>
      </form>
    </div>

    <p>使い切り期限 3日前に 通知します</p>
  </div>
</body>
</html>
