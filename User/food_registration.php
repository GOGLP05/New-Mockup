<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = $_POST['quantity'];
    $count = $_POST['count'];
    $date = $_POST['date'];

    // ここでSQLクエリを使ってデータベースに保存
    // 例: INSERT INTO food_registration (quantity, count, date) VALUES (?, ?, ?);
    
    // データベース接続コードと保存処理を追加
    echo "登録が完了しました"; // これは仮のレスポンスです
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="common.css">
  <link rel="stylesheet" href="food_registration.css">
  <title>食品登録</title>
  <script src="pop_up.js"></script>
</head>
<body>
<?php include "header.php"; ?>
  <div class="content">
    <h1>食品登録</h1>
    <div class="foods">
      <button class="button" onclick="showPopup('牛肉')">牛肉</button>
      <button class="button" onclick="showPopup('鶏肉')">鶏肉</button>
      <button class="button" onclick="showPopup('豚肉')">豚肉</button>
      <button class="button" onclick="showPopup('野菜')">野菜</button>
      <button class="button" onclick="showPopup('魚')">魚</button>
      <button class="button" onclick="showPopup('卵')">卵</button>
      <button class="button" onclick="showPopup('米')">米</button>
      <button class="button" onclick="showPopup('小麦')">小麦</button>
      <button class="button" onclick="showPopup('豆腐')">豆腐</button>
      <button class="button" onclick="showPopup('じゃがいも')">じゃがいも</button>
      <button class="button" onclick="showPopup('りんご')">りんご</button>
      <button class="button" onclick="showPopup('バナナ')">バナナ</button>
      <button class="button" onclick="showPopup('みかん')">みかん</button>
      <button class="button" onclick="showPopup('トマト')">トマト</button>
      <button class="button" onclick="showPopup('レタス')">レタス</button>
    </div>
    <div class="popup" id="popup">
      <div class="popup-content">
        <h3 id="popup-food-title">食品情報を入力</h3>
        <form id="pop_up_foodregistration">
          <label for="quantity">グラム:</label>
          <input type="number" id="quantity" name="quantity" min="1" required><br><br>

          <label for="count">個数:</label>
          <input type="number" id="count" name="count" min="1" required><br><br>

          <label for="date">登録日:</label>
          <input type="date" id="date" name="date" required><br><br>

          <button type="button" onclick="submitForm()">追加</button>
        </form>
        <button class="popup-close" onclick="closePopup()">閉じる</button>
      </div>
    </div>
  </div>
</body>
</html>