<?php
require_once 'helpers\RecipeDAO.php';

$RecipeDAO = new RecipeDAO();
$recipe = null;

if (isset($_GET['id'])) {
    // レシピIDがURLに含まれている場合、そのレシピを取得
    $recipe = $RecipeDAO->get_recipe_by_id($_GET['id']);
}

// CSRFトークンの生成
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
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
                    <button type="button" class="upload-button">アップロード</button>
                </p>

                <!-- 利用食品 -->
                <h2>利用食品</h2>
                <table class="ingredients-table">
                    <thead>
                        <tr>
                            <th>食品名</th>
                            <th>表示用使用料</th>
                            <th>単位</th>
                            <th>算出用値</th>
                        </tr>
                    </thead>
                    <tbody id="ingredientsTable">
                        <?php if ($recipe && !empty($recipe->ingredients)) : ?>
                            <?php foreach ($recipe->ingredients as $ingredient) : ?>
                                <tr>
                                    <td><input type="text" name="ingredient_name[]" 
                                        value="<?= htmlspecialchars($ingredient['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></td>
                                    <td><input type="number" name="ingredient_quantity[]" 
                                        value="<?= htmlspecialchars($ingredient['quantity'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required></td>
                                    <td>
                                        <select name="ingredient_unit[]">
                                            <option value="g" <?= ($ingredient['unit'] ?? '') === 'g' ? 'selected' : '' ?>>g</option>
                                            <option value="個" <?= ($ingredient['unit'] ?? '') === '個' ? 'selected' : '' ?>>個</option>
                                            <option value="本" <?= ($ingredient['unit'] ?? '') === '本' ? 'selected' : '' ?>>本</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="ingredient_value[]" 
                                        value="<?= htmlspecialchars($ingredient['value'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php for ($i = 0; $i < 3; $i++) : ?>
                                <tr>
                                    <td><input type="text" name="ingredient_name[]"></td>
                                    <td><input type="number" name="ingredient_quantity[]" value="0" required></td>
                                    <td>
                                        <select name="ingredient_unit[]">
                                            <option value="g">g</option>
                                            <option value="個">個</option>
                                            <option value="本">本</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="ingredient_value[]"></td>
                                </tr>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="button" class="add-row-button btn btn-primary">行を追加</button>

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
                    <button type="submit" class="update btn btn-success">更新</button>
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
        document.querySelector('.add-row-button').addEventListener('click', function() {
            const tableBody = document.querySelector('#ingredientsTable');
            const rowCount = tableBody.rows.length;

            // 最大20行まで追加
            if (rowCount < 20) {
                const newRow = `
                    <tr>
                        <td><input type="text" name="ingredient_name[]"></td>
                        <td><input type="number" name="ingredient_quantity[]" value="0" required></td>
                        <td>
                            <select name="ingredient_unit[]">
                                <option value="g">g</option>
                                <option value="個">個</option>
                                <option value="本">本</option>
                            </select>
                        </td>
                        <td><input type="text" name="ingredient_value[]"></td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', newRow);
            } else {
                alert("利用食品は最大20までです。");
            }
        });

    </script>

</body>
</html>
