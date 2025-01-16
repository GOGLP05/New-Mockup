<?php
    require_once 'helpers\SeasoningMasterDAO.php';

    $SeasoningMasterDAO = new SeasoningMasterDAO();

    $seasoning_list = $SeasoningMasterDAO->get_seasonings();

?>

<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_list_of_seasonings.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>調味料一覧</title>
    <style>
       

    </style>
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a>>
        <span>調味料一覧</span>
    </ul>

    <h1>調味料一覧</h1>

    <div class="button-container">
        <a href="admin_seasoning_detail.php?action=new">
            <button>新規登録</button>
        </a>
    </div>

    <table>
            <tr>
                <th>調味料ID</th>
                <th>調味料名</th>
                <th>操作</th>

            </tr>
        <?php foreach ($seasoning_list as $seasoningMaster) : ?>
            <tr>
                <td><?= htmlspecialchars($seasoningMaster->seasoning_id, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($seasoningMaster->seasoning_name, ENT_QUOTES, 'UTF-8') ?></td>
                <!-- 詳細ボタン -->
                <td>
                    <a href="admin_seasoning_detail.php?action=edit&seasoning_id=<?= htmlspecialchars($seasoningMaster->seasoning_id, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="button" value="詳細">
                    </a>
                </td>
            </tr>            
        <?php endforeach; ?>
    </table>
</body>
</html>
