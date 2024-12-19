<?php
    require_once 'helpers\CategoryDAO.php';

    $CategoryDAO = new CategoryDAO();

    $category_list = $CategoryDAO->get_categories();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>食品カテゴリ登録/編集</title>
        <!-- Bootstrap CSS -->
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
            <label for="categoriesid">カテゴリID:</label>
            <div class="masked-text" id="categoriesid">******</div>

            <label for="categoriesname">カテゴリ名:</label>
            <input type="text" id="categoriesname" name="categoriesname" placeholder="カテゴリ名を入力">

            <div class="button-container">
                <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#Modal">削除</button>
                <button class="update">更新</button>
            </div>
        </div>

        <!-- モーダル -->
        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <p>カテゴリ******を削除します。</p><br>
                            <p>よろしいですか？</p>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">はい</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // カテゴリIDの実際の値
            const actualCategoryId = "123456";

            // 伏字用にマスキングする
            const maskedCategoryId = actualCategoryId.replace(/./g, "*");

            // ページ読み込み時に伏字を表示
            document.getElementById("categoriesid").textContent = maskedCategoryId;
        </script>

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
