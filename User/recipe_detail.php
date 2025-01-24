<?php
session_start();
$memberId = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : 0;
$recipeId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$memberId = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : 0;
$recipeId = isset($_GET['id']) ? intval($_GET['id']) : 0;

require_once 'helpers/RecipeMasterDAO.php';
require_once 'helpers/CategoryDAO.php';
require_once 'helpers/FoodMasterDAO.php';

$FoodMasterDAO = new FoodMasterDAO();
$recipeMasterDAO = new Recipe_MasterDAO();
$categoryDAO = new CategoryDAO();

$foodmaster_list = $FoodMasterDAO->get_foods(); // 食品データの取得
$recipe = $recipeMasterDAO->get_recipe_by_id($recipeId);
$ingredients = $recipeMasterDAO->get_ingredients_by_recipe_id($recipeId);
$seasonings = $recipeMasterDAO->get_seasonings_by_recipe_id($recipeId);


$category_data = [];

// 該当レシピが存在しない場合の処理
if (!$recipe) {
    echo "指定されたレシピは存在しません。";
    exit;
}

$ingredient_category_ids = []; // 結果を格納する配列

$ingredient_category_ids = []; // カテゴリーIDのみを格納する配列

foreach ($ingredients as $ingredient) {
    if (isset($ingredient['food_id'])) {
        // food_id に対応する category_id を取得
        $category_id = $FoodMasterDAO->get_category_by_food_id($ingredient['food_id']);
        if ($category_id !== null) { // category_id が存在する場合のみ格納
            $ingredient_category_ids[] = $category_id;
        } else {
            echo "food_id " . $ingredient['food_id'] . " に対応する category_id が見つかりませんでした。<br>";
        }
    } else {
        echo "food_id が見つかりませんでした。<br>";
    }
}
$ingredient_units = [];

// 食材ごとにカテゴリーIDと単位を取得
foreach ($ingredients as $ingredient) {
    if (isset($ingredient['food_id'])) {
        // food_id から category_id を取得
        $category_id = $FoodMasterDAO->get_category_by_food_id($ingredient['food_id']);
        if ($category_id && is_array($category_id) && count($category_id) > 0) {
            // 複数結果が返る可能性があるので最初の結果を取得
            $category_id = $category_id[0]['category_id'];

            // category_id から単位を取得
            $unit = $categoryDAO->get_use_unit_by_category_id($category_id);
            $ingredient_units[$ingredient['food_id']] = $unit; // 結果を格納
        } else {
            // カテゴリーIDが取得できない場合のデフォルト
            $ingredient_units[$ingredient['food_id']] = '不明な単位';
        }
    } else {
        $ingredient_units[$ingredient['food_id']] = '不明な単位';
    }
}

// $ingredient_units の内容を確認（デバッグ用）
var_dump($ingredient_units);



// 結果を確認
var_dump($category_id);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, Sinitial-scale=1.0">
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
            <li><a class="menu__item" href="recipe_list.php">レシピ一覧</a></li>
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
                <?= htmlspecialchars($ingredient['display_use'] ?? '不明な数量', ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($ingredient_units[$ingredient['food_id']] ?? '不明な単位', ENT_QUOTES, 'UTF-8') ?>
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

                <input type="number" id="serving-number" name="serving-number" value="1" min="1" max="20">
                <label for="serving-number">人前</label>
            </div>

            <button class="make" id="make-button">作った</button>
        </div>
    </div>

</body>

<script>
    const recipeId = <?= json_encode($recipeId) ?>; // PHP から recipeId を渡す
    const memberId = <?= json_encode($memberId) ?>; // PHP から memberId を渡す

    document.getElementById("make-button").addEventListener("click", function() {
        const servingCount = parseInt(document.getElementById("serving-number").value, 10) || 1;

        // AJAXリクエストを送信
        fetch("helpers/update_food.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    recipe_id: recipeId,
                    serving_count: servingCount,
                    member_id: memberId, // memberId を一緒に送信
                }),
            })
            .then((response) => response.text()) // レスポンスをテキストで取得
            .then((data) => {
                console.log(data); // レスポンスの内容をログに出力して確認
                try {
                    const jsonData = JSON.parse(data); // 明示的にJSONとしてパース
                    if (jsonData.success) {
                        alert("食材の消費量を更新しました！");
                    } else {
                        alert("更新中にエラーが発生しました: " + jsonData.message);
                    }
                } catch (error) {
                    alert("食材の消費量を更新しました！");
                }
            })
            .catch((error) => {
                console.error("通信エラー:", error);
                alert("通信エラーが発生しました_recipe_detail。");
            });
    });
</script>

</html>