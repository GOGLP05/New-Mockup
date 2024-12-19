<?php
require_once 'helpers/RecipeMasterDAO.php';

// RecipeMasterDAOのインスタンスを作成し、データを取得
$recipeMasterDAO = new Recipe_MasterDAO();
$recipes = $recipeMasterDAO->get_recipes();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="top.css">
    <title>TOP</title>
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
        <div class="tape">
            <h1>作れる料理</h1>
        </div>
        <div class="dishes_can_make">
    <?php if (!empty($recipes)) : ?>
        <?php foreach ($recipes as $recipe) : ?>
            <a href="recipe_detail.php?id=<?= htmlspecialchars($recipe->recipe_id, ENT_QUOTES, 'UTF-8') ?>">
                <div class="image-container">
                    <img src="<?= htmlspecialchars($recipe->recipe_file_path1, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="image-text"><?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else : ?>
        <p>表示できる料理がありません。</p>
    <?php endif; ?>
</div>

<div>
            <h1>使い切り期限が近い食材</h1>
            <table class="expiring_soon">
                <thead>
                    <tr>
                        <th>食材名</th>
                        <th>数量</th>
                        <th>残り日数</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>じゃがいも</td>
                        <td>3個</td>
                        <td>あと3日</td>
                    </tr>
                    <tr>
                        <td>さつまいも</td>
                        <td>5個</td>
                        <td>あと4日</td>
                    </tr>
                    <tr>
                        <td>里芋</td>
                        <td>3個</td>
                        <td>あと4日</td>
                    </tr>
                    <tr>
                        <td>玉ねぎ</td>
                        <td>2個</td>
                        <td>あと6日</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <h1>使い切り期限が過ぎた食材</h1>
            <table class="expired">
                <thead>
                    <tr>
                        <th>食材名</th>
                        <th>数量</th>
                        <th>経過日数</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>牛乳</td>
                        <td>1本</td>
                        <td>3日</td>
                    </tr>
                    <tr>
                        <td>木綿豆腐</td>
                        <td>1丁</td>
                        <td>3日</td>
                    </tr>
                    <tr>
                        <td>みょうが</td>
                        <td>1個</td>
                        <td>4日</td>
                    </tr>
                    <tr>
                        <td>納豆</td>
                        <td>3個</td>
                        <td>6日</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
