<?php
require_once 'helpers/RecipeMasterDAO.php';
require_once 'helpers/CategoryDAO.php';
require_once 'helpers/FoodMasterDAO.php';

$FoodMasterDAO = new FoodMasterDAO();
$foodmaster_list = $FoodMasterDAO->get_foods(); // 食品データの取得

// レシピIDを取得
$recipeId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// DAOから該当レシピを取得
$recipeMasterDAO = new Recipe_MasterDAO();
$recipe = $recipeMasterDAO->get_recipe_by_id($recipeId);
$ingredients = $recipeMasterDAO->get_ingredients_by_recipe_id($recipeId);
$seasonings = $recipeMasterDAO->get_seasonings_by_recipe_id($recipeId);

// CategoryDAOのインスタンスを作成
$categoryDAO = new CategoryDAO(); // $dbはDB接続オブジェクト

// 各食材のカテゴリーIDを使ってカテゴリーを取得
$category_data = []; // カテゴリーデータを格納する配列

foreach ($foodmaster_list as $food) {
    $categoryId = $food->category_id; // 各食品のcategory_idを取得
    if (!isset($category_data[$categoryId])) {
        $category_data[$categoryId] = $categoryDAO->get_use_unit_by_category_id($categoryId);
    }
}

// 該当レシピが存在しない場合の処理
if (!$recipe) {
    echo "指定されたレシピは存在しません。";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="recipe_detail.css">
    <title><?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body>
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
        <div class="details">
            <h1><?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?></h1>
            <div class="photo">
                <img src="<?= htmlspecialchars($recipe->recipe_file_path1, ENT_QUOTES, 'UTF-8') ?>"
                    alt="<?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <!-- 食材と調味料を横並びに配置 -->
            <div class="ingredients-seasonings">
                <div class="ingredients">
                    <h2>必要な食材</h2>
                    <ul>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li>
                                <span class="ingredients-name"><?= htmlspecialchars($ingredient['food_name'] ?? '不明な食材', ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="ingredients-quantity">
                                    <?php
                                    // 食材のカテゴリーIDを取得
                                    $ingredient_category_id = $ingredient['category_id']; // 食材のカテゴリーIDを正しく取得
                                    if (!isset($category_data[$ingredient_category_id])) {
                                        $category_data[$ingredient_category_id] = $categoryDAO->get_use_unit_by_category_id($ingredient_category_id);
                                    }
                                    $unit = $category_data[$ingredient_category_id] ?? 'g'; // 単位の取得
                                    ?>
                                    <?= htmlspecialchars($ingredient['quantity'] ?? '不明な数量', ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($unit, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="seasonings">
                    <h2>必要な調味料</h2>
                    <ul>
                        <?php foreach ($seasonings as $seasoning): ?>
                            <li>
                                <span class="seasoning-name"><?= htmlspecialchars($seasoning['seasoning_name'] ?? '不明な調味料', ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="seasoning-quantity"><?= htmlspecialchars($seasoning['display_use'] ?? 'なし', ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($seasoning['unit'] ?? '不明な単位', ENT_QUOTES, 'UTF-8') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- 手順を下部に配置 -->
            <div class="steps">
                <h2>手順</h2>
                <ol>
                    <?php foreach ($recipe->processes as $process): ?>
                        <li>
                            <p><?= nl2br(htmlspecialchars(str_replace("\\n", "\n", $process), ENT_QUOTES, 'UTF-8')) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>

            <!-- 何人前選択カウンター -->
            <div class="serving-counter">
                <label for="serving-number">何人前:</label>
                <input type="number" id="serving-number" name="serving-number" value="1" min="1" max="20">
            </div>

            <button class="make" id="make-button">作った</button>
        </div>
    </div>

</body>

<script>
    document.getElementById('make-button').addEventListener('click', function() {
        // 選択した人数を取得
        const servingNumber = document.getElementById('serving-number').value;

        // ポップアップ表示
        if (confirm("使った食材が食品庫から消費されます。よろしいですか？")) {
            // 食品庫の更新処理
            fetch('/update_food_inventory.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        recipeId: <?= $recipeId ?>,
                        servings: servingNumber
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("食品庫を更新しました！");
                    } else {
                        alert("更新に失敗しました。");
                    }
                })
                .catch(error => {
                    console.error('エラー:', error);
                    alert("エラーが発生しました。詳細: " + error.message);
                });
        }
    });
</script>

</html>