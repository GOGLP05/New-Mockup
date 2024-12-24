<?php
    require_once 'helpers\FoodMasterDAO.php';

    $FoodMasterDAO = new FoodMasterDAO();

    $food_list = $FoodMasterDAO->get_foods();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品一覧</title>
    <link rel="stylesheet" href="admin_list_of_food.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <span>食品一覧</span>
    </ul>

    <h1>食品一覧</h1>

    <!-- 新規登録ボタン -->
    <div class="button-container">
        <a href="admin_food_registration.php">
            <button>新規登録</button>
        </a>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modal">
                    削除</button>

        <!--<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modal">削除</button>-->
                

    <!-- 食品テーブル -->
    <table>
            <tr>
                <th>食品ID</th>
                <th>食品名</th>
                <th>カテゴリ名</th>
                <th>基準単位グラム</th>
                <th>使い切り期限</th>
                <th>食品写真ファイルパス</th>
            </tr>
            <?php foreach ($food_list as $foodmaster) : ?>
            <tr>
                <td><?= htmlspecialchars($foodmaster->food_id, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($foodmaster->food_name, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($foodmaster->category_name, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($foodmaster->standard_gram, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($foodmaster->expiry_date, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($foodmaster->food_file_path, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endforeach; ?>
    </table>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
