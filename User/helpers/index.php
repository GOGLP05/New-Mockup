<?php
    require_once 'Food_MasterDAO.php';


    $FoodMasterDAO = new Food_MasterDAO();

    $foodmaster_list = $FoodMasterDAO->get_foods();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品マスター一覧</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>食品名</th>
        </tr>
        <?php foreach ($foodmaster_list as $food) : ?>
            <tr>
                <td><?= htmlspecialchars($food->food_name, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
