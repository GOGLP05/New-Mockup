<?php
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'guest@example.com';
?>

<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="setting.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定</title>
</head>

<div class="hamburger-menu"></div>
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
      <span></span>
    </label>

    <ul class="menu__box">
      <li><a class="menu__item" href="setting.html">設定</a></li>
      <li><a class="menu__item" href="list_of_food.html">食品庫</a></li>
      <li><a class="menu__item" href="food_registration.html">食品登録</a></li>
      <li><a class="menu__item" href="top.html">TOP</a></li>
    </ul>
  </div>


  <div class="content">
    <h1>設定</h1>
    <input type="button" class="sub_content" onclick="location.href='setting_account.html'" value="アカウント">
    <div  class="notification">
        <div class="notification-button">
          <input type="button" class="sub_content" onclick="" value="通知">
        </div>
      </div>
    
    <div class="notification">
      スイッチ
    </div>
    <p>使い切り期限 3日前に 通知します</p>
    
</div>

</html>