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
  </div>

  <div class="content">
    <h1>食品庫</h1>
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
        <tr>
          <td><a href="food_detail.php">じゃがいも</a></td>
          <td>2024/09/26</td>
          <td>2024/10/12</td>
          <td>5個</td>
        </tr>
        <tr>
          <td><a href="food_detail.php">牛乳</a></td>
          <td>2024/10/02</td>
          <td>2024/10/09</td>
          <td>6本</td>
        </tr>
        <tr>
          <td>卵</td>
          <td>2024/10/03</td>
          <td>2024/10/17</td>
          <td>1個</td>
        </tr>
        <tr>
          <td>食パン</td>
          <td>2024/10/05</td>
          <td>2024/10/07</td>
          <td>1個</td>
        </tr>

      </tbody>
    </table>
  </div>

</body>

</html>