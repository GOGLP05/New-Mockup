<?php
require_once 'helpers\RecipeDAO.php';
require_once 'helpers/FoodMasterDAO.php';
require_once 'helpers/SeasoningMasterDAO.php';
require_once 'helpers/CategoryDAO.php';

$categoryDAO = new CategoryDAO();


// レシピIDがURLに含まれている場合、そのレシピを取得
$RecipeDAO = new RecipeDAO();
$FoodMasterDAO = new FoodMasterDAO();
$SeasoningMasterDAO = new SeasoningMasterDAO();
// GETパラメータからレシピIDを取得
$recipe = $RecipeDAO->get_recipe_by_id($_GET['id']);
$all_foods =$FoodMasterDAO->get_foods();

$all_seasonings=$SeasoningMasterDAO->get_seasonings();
$foods = $RecipeDAO->get_ingredients_by_recipe_id($recipe->recipe_id);  //レシピに使う食品
$seasonings = $RecipeDAO->get_seasonings_by_recipe_id($recipe->recipe_id);


//$ingredients = $RecipeDAO->get_ingredients_by_recipe_id($recipe[food_name]);

// CSRFトークンの生成と検証
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRFトークンの検証
    if ($_POST['csrf_token'] !== $csrf_token) {
        die('不正なリクエストです。');
    }

    if (isset($_POST['delete_recipe'])) {
        // 削除処理
        if (!empty($_POST['recipe_id'])) {
            $recipe_id = $_POST['recipe_id'];
            if ($RecipeDAO->delete_recipe($recipe_id)) {
                $message = "レシピを削除しました。";
            } else {
                $message = "レシピの削除に失敗しました。";
            }
        }
    } elseif (isset($_POST['update_recipe']) || isset($_POST['add_recipe'])) {
        // 更新または追加処理
        $recipe_id = $_POST['recipe_id'] ?? null;
        $recipe_name = $_POST['recipe_name'];
        $ingredients = $_POST['ingredient_name'] ?? [];
        $quantities = $_POST['ingredient_quantity'] ?? [];
        $units = $_POST['ingredient_unit'] ?? [];
        $values = $_POST['ingredient_value'] ?? [];
        $steps = [];
        for ($i = 1; $i <= 10; $i++) {
            $steps["process_$i"] = $_POST["process_$i"] ?? null;
        }

        // 更新か追加の分岐
        if (isset($_POST['update_recipe'])) {
            // 更新
            if ($RecipeDAO->update_recipe($recipe_id, $recipe_name, $ingredients, $quantities, $units, $values, $steps)) {
                $message = "レシピを更新しました。";
            } else {
                $message = "レシピの更新に失敗しました。";
            }
        } elseif (isset($_POST['add_recipe'])) {
            // 追加
            if ($RecipeDAO->add_recipe($recipe_name, $ingredients, $quantities, $units, $values, $steps)) {
                $message = "レシピを追加しました。";
            } else {
                $message = "レシピの追加に失敗しました。";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レシピ管理</title>
    <link rel="stylesheet" href="admin_recipe_registration.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php
// foreach ($foods as $food) {
//     // get_category_by_food_id() が返すオブジェクトを取得
//     $foodMaster = $FoodMasterDAO->get_category_by_food_id($food['food_id']);
    
//     // 配列の最初の要素（オブジェクト）から category_id を取り出す
//     $category_id = $foodMaster[0]->category_id;
    
//     // category_id を表示
//     var_dump($category_id);
    
//     // get_use_unit_by_category_id() の処理はそのまま
//     $unit = $categoryDAO->get_use_unit_by_category_id($category_id);
    
//     // 取得した単位（$unit）を表示
//     var_dump($unit);
// }
?>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <a href="admin_list_of_recipe.php">登録レシピ一覧</a> >
        <span>レシピ登録/編集</span>
    </ul>

    <h1>レシピ登録/編集</h1>

    <div class="container">
        <div class="recipe-form">
            <form id="recipeForm" method="POST" action="save_recipe.php">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

                <label for="recipe_id">レシピID</label>
                <div class="masked-text" id="recipe_id">
                    <?= htmlspecialchars($recipe->recipe_id ?? '******', ENT_QUOTES, 'UTF-8') ?>
                </div>

                <label for="recipe_name">レシピ名</label>
                <input type="text" id="recipe_name" name="recipe_name"
                    value="<?= htmlspecialchars($recipe->recipe_name ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                    <p class="upload-row">
                        <label for="recipe_file_path1">レシピ写真1</label>
                        <!-- ファイル選択のためのinputフィールド -->
                        <input type="file" id="recipe_file_path1" name="recipe_file_path1" style="display: none;" accept="image/*">
                        <!-- アップロードボタン -->
                        <button type="button" class="upload-button" id="uploadButton">アップロード</button>
                    </p>

                <!-- 画像のプレビュー表示領域 -->
                <div id="imagePreviewContainer" style="display: none;">
                    <h3>選択した画像：</h3>
                    <!-- 画像プレビュー -->
                    <img id="imagePreview" src="" alt="画像プレビュー" style="max-width: 300px; max-height: 300px;">
                    <!-- ファイル名の表示 -->
                    <p id="fileName" style="margin-top: 10px;"></p>
                </div>


                <h2>利用食品</h2>
                <table class="ingredients-table">
                    <thead>
                        <tr>
                            <th>食品名</th>
                            <th>算出用値</th>
                            <th>単位</th>
                            <th>表示用値</th>
                        </tr>
                    </thead>

                    <tbody id="ingredientsTable">
                        <?php if ($recipe->ingredients && !empty($recipe->ingredients)) : ?>
                            <?php foreach ($recipe->ingredients as $ingredient) : ?>
                                <tr>
                                    <td>
                                        <select name="ingredient_name[]">
                                            <?php foreach ($all_foods as $food) : ?>
                                                <option value="<?= htmlspecialchars($food->food_id, ENT_QUOTES, 'UTF-8') ?>" 
                                                    <?= (isset($ingredient['food_name']) && $ingredient['food_name'] === $food->food_name) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($food->food_name, ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="ingredient_calculation_use[]" value="<?= htmlspecialchars($ingredient['calculation_use'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    </td>
           
                                    <td>
                                        <input type="text" name="ingredient_display_use[]" value="<?= htmlspecialchars($ingredient['display_use'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    </td>
                                    <td>
                                        <select name="ingredient_unit[]">
                                            <option value="0">g</option>
                                            <option value="1">個</option>
                                            <option value="3">ml</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php for ($i = 0; $i < 3; $i++) : ?>
                                <tr>
                                    <td>
                                        <select name="ingredient_name[]">
                                            <?php foreach ($foods as $food) : ?>
                                                <option value="<?= htmlspecialchars($food['food_id'], ENT_QUOTES, 'UTF-8') ?>">
                                                    <?= htmlspecialchars($food['food_name'], ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><input type="number" name="ingredient_calculation_use[]" value="0" required></td>
                                    <td>
                                        <select name="ingredient_unit[]">
                                            <option value="0">g</option>
                                            <option value="1">個</option>
                                            <option value="3">ml</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="ingredient_display_use[]"></td>
                                </tr>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <button type="button" class="add-row-button btn btn-primary">行を追加</button>

                <h2>利用調味料</h2>
                
<table class="ingredients-table">
    <thead>
        <tr>
            <th>調味料名</th>
            <th>単位</th>
            <th>表示用値</th>
        </tr>
    </thead>
    <tbody id="ingredientsTable2">
        <?php if ($recipe && !empty($seasonings)) : ?>
            <?php foreach ($seasonings as $seasoning) : ?>
    <tr>
        <td>
            <select name="seasoning_name[]">
                <?php foreach ($all_seasonings as $seasoningItem) : ?>
                    <option value="<?= htmlspecialchars($seasoningItem->seasoning_id, ENT_QUOTES, 'UTF-8') ?>"
                    <?= ($seasoning['seasoning_name'] === $seasoningItem->seasoning_name) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($seasoningItem->seasoning_name, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><input type="text" name="seasoning_display_use[]" value="<?= htmlspecialchars($seasoning['display_use'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></td>
        <td>
            <select name="seasoning_unit[]">
                <option value="g" <?= ($seasoning['unit'] === 'g') ? 'selected' : '' ?>>g</option>
                <option value="個" <?= ($seasoning['unit'] === '個') ? 'selected' : '' ?>>個</option>
                <option value="ml" <?= ($seasoning['unit'] === 'ml') ? 'selected' : '' ?>>ml</option>
                <option value="大さじ" <?= ($seasoning['unit'] === '大さじ') ? 'selected' : '' ?>>大さじ</option>
                <option value="小さじ" <?= ($seasoning['unit'] === '小さじ') ? 'selected' : '' ?>>小さじ</option>
            </select>
        </td>
        
    </tr>
<?php endforeach; ?>

        <?php else : ?>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <tr>
                    <td>
                        <select name="seasoning_name[]">
                            <?php foreach ($seasonings as $seasoningItem) : ?>
                                <option value="<?= htmlspecialchars($seasoningItem->seasoning_name, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($seasoningItem->seasoning_name, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="seasoning_calculation_use[]" value="0" required></td>
                    <td>
                        <select name="seasoning_unit[]">
                            <option value="g">g</option>
                            <option value="個">個</option>
                            <option value="ml">ml</option>
                        </select>
                    </td>
                    <td><input type="text" name="seasoning_display_use[]"></td>
                </tr>
            <?php endfor; ?>
        <?php endif; ?>
    </tbody>
</table>
<button type="button" class="add-row-button2 btn btn-primary">行を追加</button>

                <!-- 手順 -->
                <h2>手順</h2>
                <div id="steps">
                    <?php 
                    $stepCount = 0;
                    // 最大10手順まで表示
                    for ($i = 1; $i <= 10; $i++) : 
                        // レシピに手順が設定されていればその内容を表示、設定されていなければ空のテキストエリアを表示
                        $stepContent = !empty($recipe->{'process_' . $i}) ? nl2br(htmlspecialchars($recipe->{'process_' . $i}, ENT_QUOTES, 'UTF-8')) : '';
                    ?>
                        <label for="process_<?= $i ?>">手順<?= $i ?></label>
                        <textarea id="process_<?= $i ?>" name="process_<?= $i ?>" rows="6"><?= $stepContent ?></textarea>
                    <?php endfor; ?>
                </div>

                <div class="button-container">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modal">削除</button>
                    <?php if ($recipe) : ?>
                        <!-- レシピが存在する場合は「更新」ボタン -->
                        <button type="submit" class="update btn btn-success">更新</button>
                    <?php else : ?>
                        <!-- 新規登録の場合は「追加」ボタン -->
                        <button type="submit" class="add btn btn-primary">追加</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- モーダル -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">レシピ削除確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="delete_recipe.php">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe->recipe_id ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <p>レシピ「<?= htmlspecialchars($recipe->recipe_name ?? '******', ENT_QUOTES, 'UTF-8') ?>」を削除します。</p>
                        <p>よろしいですか？</p>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">はい</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">いいえ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 行を追加するボタン（利用食品）
        document.querySelector('.add-row-button').addEventListener('click', function () {
        const tableBody = document.querySelector('#ingredientsTable');
        const rowCount = tableBody.rows.length;

        if (rowCount < 20) {
            const newRow = `
                <tr>
                    <td>
                        <select name="ingredient_name[]">
                            <?php foreach ($all_foods as $food) : ?>
                                <option value="<?= htmlspecialchars($food->food_id, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($food->food_name, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="ingredient_calculation_use[]" value="0" required>
                    </td>

                    <td>
                        <input type="text" name="ingredient_display_use[]">
                    </td>
                                        <td>
                        <select name="ingredient_unit[]">
                            <option value="g">g</option>
                            <option value="個">個</option>
                            <option value="ml">ml</option>
                        </select>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
        } else {
            alert("利用食品は最大20までです。");
        }
    });

        // 行を追加するボタン（利用調味料）
        document.querySelector('.add-row-button2').addEventListener('click', function() {
    const tableBody = document.querySelector('#ingredientsTable2');
    const rowCount = tableBody.rows.length;

    // 最大20行まで追加
    if (rowCount < 20) {
        const newRow = `
            <tr>
                <td>
                    <select name="seasoning_name[]">
                        <?php foreach ($all_seasonings as $seasoningItem) : ?>
                            <option value="<?= htmlspecialchars($seasoningItem->seasoning_id, ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($seasoningItem->seasoning_name, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="seasoning_display_use[]">
                </td>
                <td>
                    <select name="seasoning_unit[]">
                        <option value="g">g</option>
                        <option value="個">個</option>
                        <option value="ml">ml</option>
                        <option value="大さじ">大さじ</option>
                        <option value="小さじ">小さじ</option>
                    </select>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
    } else {
        alert("利用調味料は最大20までです。");
    }
});
// アップロードボタンがクリックされた時にファイル選択ダイアログを開く
document.getElementById('uploadButton').addEventListener('click', function() {
    document.getElementById('recipe_file_path1').click();  // input[type="file"] をクリック
});

// ファイルが選択された時に画像をプレビュー表示
document.getElementById('recipe_file_path1').addEventListener('change', function(event) {
    const file = event.target.files[0];  // 選択されたファイルを取得
    
    if (file) {
        const reader = new FileReader();  // FileReaderオブジェクトを作成
        
        reader.onload = function(e) {
            // 画像をプレビューとして表示
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result;  // プレビュー画像のsrcを設定

            // ファイル名を表示
            const fileName = document.getElementById('fileName');
            fileName.textContent = `選択したファイル名: ${file.name}`;

            // プレビュー表示領域を表示
            document.getElementById('imagePreviewContainer').style.display = 'block';
        };

        // 画像ファイルをData URLとして読み込む
        reader.readAsDataURL(file);
    }
});

        
    </script>

</body>

</html>
