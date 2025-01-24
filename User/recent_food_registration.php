<?php
require_once 'helpers/RegisteredFoodDAO.php';
require_once 'helpers/FoodMasterDAO.php';
require_once 'helpers/CategoryDAO.php';

session_start(); // セッションを開始
if (!isset($_SESSION['member_id'])) {
    die('ログインしてください。');
}

$member_id = $_SESSION['member_id']; // セッションからmember_idを取得
$FoodMasterDAO = new FoodMasterDAO();
$RegisteredFoodDAO = new RegisteredFoodDAO();
$CategoryDAO = new CategoryDAO();

try {
    $foodmaster_list = $RegisteredFoodDAO->get_registered_foods_with_images_by_member($member_id);
} catch (Exception $e) {
    die('データの取得に失敗しました: ' . htmlspecialchars($e->getMessage()));
}
$use_unit =0;
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
        <li><a class="menu__item" href="recipe_list.php">レシピ一覧</a></li>
        <li><a class="menu__item" href="food_registration.php">食品登録</a></li>
        <li><a class="menu__item" href="setting.php">設定</a></li>
    </ul>

    <div class="content">
        <h1>最近登録した食品</h1>
        <div class="recent_registration"> <button onclick="location.href='food_registration.php'">戻る</button> </div>
    </div>

    <hr>
    <div class="content">
        <div class="foods">
            <?php foreach ($foodmaster_list as $food): ?>
                <?php
                // category_idに基づいてuse_unitを取得
                $use_unit = $CategoryDAO->get_use_unit_by_category_id($food->category_id);
                ?>
                <?php echo htmlspecialchars($use_unit); ?>
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
            <?php echo htmlspecialchars($use_unit); ?>
            <form onsubmit="event.preventDefault(); submitForm();">
                <input type="hidden" id="foodId" name="foodId">
                <input type="hidden" id="memberId" name="memberId">
                <input type="hidden" id="foodName" name="foodName">
                
                <input type="hidden" id="useUnit" name="useUnit" value="">
                <label for="count"><?php echo htmlspecialchars($use_unit); ?>:</label>
                <input type="text" id="count" name="count" required><br><br>

                <label for="date">購入日:</label>
                <input type="date" id="date" name="date" required><br><br>

                <button type="submit">登録</button>
            </form>
        </div>
    </div>

    <script src="pop_up.js"></script>
</body>

</html>