<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品詳細</title>
    <link rel="stylesheet" href="list_of_food.css"> <!-- 食品庫と同じCSSを利用 -->
</head>
<body>

    <div class="hamburger-menu"></div>
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
      <span></span>
    </label>

    <ul class="menu__box">
      <li><a class="menu__item" href="setting.php">設定</a></li>
      <li><a class="menu__item" href="list_of_food.php">食品庫</a></li>
      <li><a class="menu__item" href="list_of_food_registration.php">食品登録</a></li>
      <li><a class="menu__item" href="top.php">TOP</a></li>
    </ul>
  </div>

    <div class="content">
        <h1>食品詳細</h1>
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
                  <td>じゃがいも</td>
                  <td>2024/09/26</td>
                  <td>2024/10/12</td>
                  <td>2個</td>
              </tr>
              <tr>
                  <td>じゃがいも</td>
                  <td>2024/09/27</td>
                  <td>2024/10/13</td>
                  <td>3個</td>
              </tr>
              <tr>
                  <td>牛乳</td>
                  <td>2024/10/02</td>
                  <td>2024/10/09</td>
                  <td>2本</td>
              </tr>
              <tr>
                  <td>牛乳</td>
                  <td>2024/10/03</td>
                  <td>2024/10/10</td>
                  <td>4本</td>
              </tr>
          </tbody>
      </table>
    </div>

</body>
</html>
