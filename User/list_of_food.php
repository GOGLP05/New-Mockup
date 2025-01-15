<?php
require_once 'helpers/RegisteredFoodDAO.php';

$RegisteredFood = new RegisteredFoodDAO();
$foods = $RegisteredFood->get_all_foods();
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

    <h4>食品は直近に登録されたもののみを表示しています</h4>
    <table border="1">
      <thead>
        <tr>
          <th>食品名</th>
          <th>登録日</th>
          <th>使い切り期限</th>
          <th>数量</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($foods)) : ?>
          <?php foreach ($foods as $food) : ?>
            <tr>
              <td><?php echo htmlspecialchars($food['food_name'], ENT_QUOTES, 'UTF-8'); ?></td>
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
