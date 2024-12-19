<?php
    require_once 'helpers\CategoryDAO.php';

    $CategoryDAO = new CategoryDAO();

    $category_list = $CategoryDAO->get_categories();
?>

<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_list_of_food_categories.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品カテゴリー一覧</title>
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a>>
        <span>食品カテゴリー一覧</span>
    </ul>

    <h1>食品カテゴリー一覧</h1>

    <div class="button-container">
        <a href="admin_food_categories_registration.php">
            <button>新規登録</button>
        </a>
    </div>

    <table>
            <tr>
                <th>カテゴリーID</th>
                <th>カテゴリー名</th>
                <th>操作</th>
            </tr>
            <?php foreach ($category_list as $category) : ?>
            <tr>
                <td><?= htmlspecialchars($category->category_id, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($category->category_name, ENT_QUOTES, 'UTF-8') ?></td>
                <td><input type="button" onclick="location.href='admin_food_categories_registration.php'" value="編集"></td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>
</html>
