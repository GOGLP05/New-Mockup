<?php
require_once 'helpers/FoodMasterDAO.php';

$FoodMasterDAO = new FoodMasterDAO();
$foodmaster_list = $FoodMasterDAO->get_name_and_path();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="food_registration.css">
    <title>最近登録した食品</title>
    <script src="pop_up.js" defer></script>
</head>

<body>
    <input id="menu__toggle" type="checkbox">
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
        <h1>最近登録した食品</h1>
    </div>

    <hr>
    <div class="content">
        <div class="foods">
            <?php foreach ($foodmaster_list as $food): ?>
                <div class="button-container">
                    <button class="button" onclick="showPopup('<?php echo htmlspecialchars($food->food_name); ?>')" title="<?php echo htmlspecialchars($food->food_name); ?>">
                        <img src="<?php echo htmlspecialchars($food->food_file_path); ?>" alt="<?php echo htmlspecialchars($food->food_name); ?>" class="food-image">
                    </button>
                    <div class="food-name"><?php echo htmlspecialchars($food->food_name); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="popup" class="popup" style="display: none;">
        <div class="popup-content">
            <span id="popup-close" class="popup-close" onclick="closePopup()">×</span>
            <h2 id="popup-food-title"></h2>
            <form onsubmit="event.preventDefault(); submitForm();">
                <label for="quantity">数量:</label>
                <input type="text" id="quantity" name="quantity" required><br><br>
                <label for="count">個数:</label>
                <input type="text" id="count" name="count" required><br><br>
                <label for="date">日付:</label>
                <input type="date" id="date" name="date" required><br><br>
                <button type="submit">登録</button>
            </form>
        </div>
    </div>
</body>

</html>
