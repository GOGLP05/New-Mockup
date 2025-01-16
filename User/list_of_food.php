<?php
require_once 'helpers/RegisteredFoodDAO.php';
session_start();

if (!isset($_SESSION['member_id'])) {
  header('Location: login.php'); // ログインページへリダイレクト
  exit;
}

$member_id = $_SESSION['member_id'];
$RegisteredFood = new RegisteredFoodDAO();

// 食品名が指定されている場合、その食品のみを取得
$food_name = $_GET['food_name'] ?? null;

if ($food_name) {
  // 特定の食品のデータを取得
  $foods = $RegisteredFood->get_foods_by_name_and_member($food_name, $member_id);
} else {
  // 全食品を取得
  $foods = $RegisteredFood->get_all_foods_by_member($member_id);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="common.css">
  <link rel="stylesheet" href="list_of_food.css">
  <title>食品庫</title>
</head>

<body>
  <div class="hamburger-menu"></div>
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

  <div class="content">
    <h1>食品庫</h1>

    <?php if ($food_name) : ?>
      <h4>「<?php echo htmlspecialchars($food_name, ENT_QUOTES, 'UTF-8'); ?>」の一覧を表示しています</h4>
      <a href="list_of_food.php">全ての食品を見る</a>
    <?php else : ?>
      <h4>直近に登録された食品のみを表示しています</h4>
    <?php endif; ?>

    <table border="1">
      <thead>
        <tr>
          <th>食品名</th>
          <th>登録日(直近)</th>
          <th>使い切り期限(直近)</th>
          <th>数量(合計)</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($foods)) : ?>
          <?php foreach ($foods as $food) : ?>
            <tr>
              <td>
                <a href="list_of_food.php?food_name=<?php echo urlencode($food['food_name']); ?>">
                  <?php echo htmlspecialchars($food['food_name'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
              </td>
              <td><?php echo htmlspecialchars($food['registration_date'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($food['expire_date'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($food['total_amount'], ENT_QUOTES, 'UTF-8'); ?>個</td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="4">データがありません。</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>

</html>