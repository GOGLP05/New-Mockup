<?php
require_once 'helpers/DAO.php';
require_once 'helpers/FoodMasterDAO.php';


$FoodMasterDAO = new FoodMasterDAO();

$foodmaster_list = $FoodMasterDAO->get_foods();

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
        <h1>食品登録</h1>
        <div class="recent_registration">
            <input type="button" onclick="location.href='recent_food_registration.php'" value="最近登録した食品">
        </div>
    </div>

    <hr>
    <div class="content">
        <div class="foods">
            <?php foreach ($foods as $food): ?>
                <button class="button" onclick="showPopup('<?php echo htmlspecialchars($food['food_name']); ?>')" title="<?php echo htmlspecialchars($food['food_name']); ?>">
                    <img src="<?php echo htmlspecialchars($food['food_file_path']); ?>" alt="<?php echo htmlspecialchars($food['food_name']); ?>" class="food-image">
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <h3 id="popup-food-title">食品情報を入力</h3>
            <form id="pop_up_foodregistration" method="POST" action="food_registration.php">
                <input type="hidden" id="food-name" name="food">
                <label for="quantity">グラム:</label>
                <input type="number" id="quantity" name="quantity" min="1" required><br><br>

                <label for="count">個数:</label>
                <input type="number" id="count" name="count" min="1" required><br><br>

                <label for="date">登録日:</label>
                <input type="date" id="date" name="date" required><br><br>

                <button type="submit">追加</button>
                <button type="button" onclick="closePopup()">閉じる</button>
            </form>
        </div>
    </div>
</body>
</html>
