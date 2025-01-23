<?php
require_once 'helpers\CategoryDAO.php';

$CategoryDAO = new CategoryDAO();

// フォームから送信されたカテゴリIDを受け取る
$category_id = isset($_GET['id']) ? $_GET['id'] : null;
$category_name = '';

// カテゴリIDが送信された場合に編集処理
if ($category_id) {
    $category = $CategoryDAO->get_category_by_id($category_id);
    if ($category) {
        $category_name = $category->category_name;
    } else {
        // IDが無効な場合のエラーハンドリング（例: リダイレクト）
        header("Location: admin_list_of_food_categories.php");
        exit;
    }
} else {
    // 新規登録時のID自動生成
    $category_id = $CategoryDAO->get_next_category_id();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 削除処理
    if (isset($_POST['delete_category_id'])) {
        $CategoryDAO->delete_category($_POST['delete_category_id']);
        header('Location: admin_list_of_food_categories.php');
        exit;
    }

    // 新規登録・更新処理
    if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
        $category_name = $_POST['category_name'];
        $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null; // POSTからカテゴリIDを取得

        if ($category_id && $CategoryDAO->get_category_by_id($category_id)) {
            // 更新処理
            $CategoryDAO->update_category($category_id, $category_name);
        } else {
            // 新規登録処理
            $CategoryDAO->insert_category($category_name);
        }

        // 完了後、カテゴリ一覧画面にリダイレクト
        header('Location: admin_list_of_food_categories.php');
        exit;
    } else {
        // カテゴリ名が空の場合のエラーハンドリング
        echo "<script>alert('カテゴリ名を入力してください');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>食品カテゴリ登録/編集</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="admin_food_categories_registration.css">
    </head>
    <body>
        <!-- パンくずリスト -->
        <ul class="breadcrumb">
            <a href="admin_top.php">管理者TOP</a> >
            <a href="admin_list_of_food_categories.php">カテゴリ一覧</a> >
            <span>食品カテゴリ登録/編集</span>
        </ul>

        <h1>食品カテゴリ登録/編集</h1>

        <div class="container">
            <form method="POST" action="admin_food_categories_registration.php">
                <label for="categoriesid">カテゴリID:</label>
                <div class="masked-text"><?= htmlspecialchars($category_id, ENT_QUOTES, 'UTF-8') ?></div>
                <input type="hidden" name="category_id" value="<?= htmlspecialchars($category_id, ENT_QUOTES, 'UTF-8') ?>">

                <label for="categoriesname">カテゴリ名:</label>
                <input type="text" id="categoriesname" name="category_name" value="<?= htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') ?>" placeholder="カテゴリ名を入力">

                <div class="button-container">
                    <button type="submit" class="btn btn-primary">登録</button>
                    <?php if ($category_name): ?>
                        <!-- 削除ボタンはモーダルを表示 -->
                        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#Modal">削除</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- モーダル -->
        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">カテゴリ削除</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>カテゴリ <strong><?= htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8') ?></strong> (ID: <?= htmlspecialchars($category_id, ENT_QUOTES, 'UTF-8') ?>) を削除します。</p>
                        <p>よろしいですか？</p>
                        <form method="POST" action="admin_food_categories_registration.php">
                            <input type="hidden" name="delete_category_id" value="<?= htmlspecialchars($category_id, ENT_QUOTES, 'UTF-8') ?>">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-danger">はい</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">いいえ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
