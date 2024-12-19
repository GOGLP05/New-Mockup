<?php
    require_once 'helpers\RecipeDAO.php';

    $RecipeDAO = new RecipeDAO();

    $recipe_list = $RecipeDAO->get_recipes();


    $count=0;
?>

<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_list_of_recipe.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録レシピ一覧</title>
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a>>
        <span>登録レシピ一覧</span>
    </ul>

    <h1>登録レシピ一覧</h1>

    <div class="button-container">
        <a href="admin_recipe_registration.php">
            <button>新規登録</button>
        </a>
    </div>


    <table border="1">
    <?php foreach ($recipe_list as $recipe) : ?>
        <?php if ($count % 3 === 0) : // 3つごとに新しい行を開始 ?>
            <tr>
        <?php endif; ?>

        <td>
            <a href="admin_recipe_registration.php?id=<?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($recipe->recipe_name, ENT_QUOTES, 'UTF-8') ?>
            </a>
        </td>

        <?php $count++; // カウンターをインクリメント ?>

        <?php if ($count % 3 === 0) : // 行を閉じる ?>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($count % 3 !== 0) : // 最後の行が埋まっていない場合、行を閉じる ?>
        </tr>
    <?php endif; ?>
</table>
</body>
</html>
