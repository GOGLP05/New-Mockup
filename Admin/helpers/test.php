<?php
    require_once 'RecipeDAO.php';

    $RecipeDAO = new RecipeDAO();

    $recipe_list = $RecipeDAO->get_recipes();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>試作</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>カテゴリID</th>
            <th>カテゴリ名</th>
        </tr>
        <?php foreach ($category_list as $category) : ?>
            <tr>
                <td><?= htmlspecialchars($category->category_id, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($category->category_name, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
</body>
</html>
