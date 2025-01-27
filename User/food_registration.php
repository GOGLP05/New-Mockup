<?php
require_once 'helpers/FoodMasterDAO.php';
require_once 'helpers/CategoryDAO.php';

session_start(); // セッションを開始

// member_id がセッションに存在しているか確認
if (!isset($_SESSION['member_id'])) {
    // セッションがない場合はエラーメッセージを表示
    echo "ログインが必要です。";
    exit;
}

$member_id = $_SESSION['member_id'];
$FoodMasterDAO = new FoodMasterDAO();
$CategoryDAO = new CategoryDAO();

// 検索ワードを取得（GETメソッド）
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// 食品のリストを取得
if ($search_query) {
    // 検索キーワードが存在する場合、キーワードを含む食品を取得
    $foodmaster_list = $FoodMasterDAO->get_foods_by_name($search_query);
} else {
    // 検索キーワードがない場合は、すべての食品を取得
    $foodmaster_list = $FoodMasterDAO->get_foods();
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
    <h1>食品登録</h1>
    <div class="search-and-recent-container">
    <div class="search-container">
        <form method="GET" action="food_registration.php">
            <input type="text" name="search" placeholder="食品名で検索" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">検索</button>
        </form>
    </div>


    <div class="recent_registration">
        <button onclick="location.href='recent_food_registration.php'">最近登録した食材</button>
    </div>
    </div>
</div>



    <hr>


    <div class="content">

        <div class="foods">
            
            <?php foreach ($foodmaster_list as $food): ?>
                <?php
                // category_idに基づいてuse_unitを取得
                $use_unit = $CategoryDAO->get_use_unit_by_category_id($food->category_id);
                ?>
                <div class="button-container">
                <?php //echo htmlspecialchars($CategoryDAO->get_use_unit_by_category_id($food->category_id)); ?>
                    <button class="button"
                        onclick="showPopup('<?php echo htmlspecialchars($food->food_name); ?>', '<?php echo htmlspecialchars($food->food_id); ?>', '<?php echo $member_id; ?>', '<?php echo $use_unit; ?>')"
                        title="<?php echo htmlspecialchars($food->food_name); ?>">
                        <img src="<?php echo htmlspecialchars($food->food_file_path); ?>"
                            alt="<?php echo htmlspecialchars($food->food_name); ?>"
                            class="food-image">
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
                <input type="hidden" id="foodId" name="foodId">
                <input type="hidden" id="memberId" name="memberId">
                <input type="hidden" id="foodName" name="foodName">
                
                <input type="hidden" id="useUnit" name="useUnit">
                <label for="count"><?php echo htmlspecialchars($use_unit); ?>:</label>
                <input type="number" id="count" name="count" required><br><br>

                <label for="date">購入日:</label>
                <input type="date" id="date" name="date" required><br><br>

                <button type="submit">登録</button>
            </form>
        </div>
    </div>

    <script src="pop_up.js"></script>
</body>

</html>