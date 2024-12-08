<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="common.css">
  <link rel="stylesheet" href="food_registration.css">
  <title>最近登録した食品</title>
</head>

<body>
<?php include "header.php"; ?>
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
    <div class="header">
      <h1>最近登録した食品</h1>
    </div>

    <div class="recent-button">
      <input type="button" class="sub_content" onclick="history.back()" value="戻る">
    </div>

    <div class="grid">
      <div class="grid-item"><a href="#">牛乳</a></div>
      <div class="grid-item"><a href="#">卵</a></div>
      <div class="grid-item"><a href="#">食パン</a></div>
      <div class="grid-item"><a href="#">バナナ</a></div>
      <div class="grid-item"><a href="#">にら</a></div>
      <div class="grid-item"><a href="#">長ネギ</a></div>
      <div class="grid-item"><a href="#">もやし</a></div>
      <div class="grid-item"><a href="#">レタス</a></div>
      <div class="grid-item"><a href="#">鶏モモ肉</a></div>
      <div class="grid-item"><a href="#">ベーコン</a></div>
      <div class="grid-item"><a href="#">ハム</a></div>
      <div class="grid-item"><a href="#">ウインナー</a></div>
    </div>
  </div>

</body>

</html>