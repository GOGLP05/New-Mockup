<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_seasoning_detail.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>調味料詳細</title>
            <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <a href="admin_list_of_seasonings.php">調味料一覧</a> >
        <span>食品カテゴリー一覧</span>
    </ul>

    <h1>調味料詳細</h1>

    <div class="container">
        <label for="tyoumiryouid">調味料ID:</label>
        <div class="masked-text" id="tyoumiryouid">******</div>

        <label for="tyoumiryouname">調味料名:</label>
        <input type="text" id="tyoumiryouname" name="tyoumiryouname" placeholder="">

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
                            <p>調味料******を削除します。</p><br>
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
        // 調味料IDの実際の値
        const actualTyoumiryouId = "A12345";

        // 伏字用にマスキングする
        const maskedTyoumiryouId = actualTyoumiryouId.replace(/./g, "*");

        // ページ読み込み時に伏字を表示
        document.getElementById("tyoumiryouid").textContent = maskedTyoumiryouId;
    </script>
        <!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
