<?php
require_once 'helpers\FoodMasterDAO.php';

$FoodMasterDAO = new FoodMasterDAO();

$food_list = $FoodMasterDAO->get_foods();

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $food_id = trim($_POST['food_id']);

        // 削除実行
        $result = $FoodMasterDAO->delete($food_id);

        // 削除結果を表示するためのメッセージを用意
        if ($result) {
            $message = "食品ID {$food_id} を削除しました。更新してください。";
        } else {
            $message = "食品ID {$food_id} は存在しません。";
        }
    }
}
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

    <!-- 削除ボタン -->
    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">削除</button>
    </div>

    <?php if (isset($message)) : ?>
        <div class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <!-- 食品テーブル -->
    <table>
        <tr>
            <th>食品ID</th>
            <th>食品名</th>
            <th>カテゴリ名</th>
            <th>基準単位グラム</th>
            <th>使い切り期限</th>
            <th>食品写真ファイルパス</th>
            <th>操作</th>

        </tr>
        <?php foreach ($food_list as $foodmaster) : ?>
        <tr>
            <td><?= htmlspecialchars($foodmaster->food_id, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($foodmaster->food_name, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($foodmaster->category_name, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($foodmaster->standard_gram, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($foodmaster->expiry_date, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($foodmaster->food_file_path, ENT_QUOTES, 'UTF-8') ?></td>
            <td><a href="admin_food_registration.php?food_id=<?= htmlspecialchars($foodmaster->food_id, ENT_QUOTES, 'UTF-8') ?>"><button>詳細</button></a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- モーダル -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">食品情報の削除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="food_id" class="form-label">削除する食品IDを入力してください</label>
                            <input type="text" class="form-control" id="food_id" name="food_id" required>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger" name="delete">削除</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
