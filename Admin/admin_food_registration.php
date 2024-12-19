<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_food_registration.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品登録/編集</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <a href="admin_list_of_food.php">食品一覧</a> >
        <span>食品登録/編集</span>
    </ul>

    <h1>食品登録/編集</h1>

    <div class="container">
        <label for="foodid">食品ID:</label>
        <div class="masked-text" id="foodid">******</div>

        <label for="foodname">食品名:</label>
        <input type="text" id="foodname" name="foodname" placeholder="">

        <label for="standardgrams">基準グラム:</label>
        <input type="text" id="standardgrams" name="standardgrams" placeholder="">

        <label for="deadline">使い切り期限:</label>
        <input type="text" id="deadline" name="deadline" placeholder="">

        <label for="unit">単位:</label>
        <select name="options" id="options">
            <option value="option1">g</option>
            <option value="option2">個</option>
            <option value="option3">本</option>
            <option value="option4">枚</option>
            <option value="option4">パック</option>
            <option value="option4">束</option>
            <option value="option4">玉</option>
            <option value="option4">株</option>
            <option value="option4">節</option>
            <option value="option4">匹</option>
        </select>      
        <label for="foodphoto">食品写真:</label>
        <!--  <button id="foodphoto" name="foodphoto">アップロード</button>-->
        <button id="foodphoto" name="foodphoto">アップロード</button>
        <!--<img src="User\img\nikujaga.jpg" alt="肉じゃがの写真">-->

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
                            <p>食品******を削除します。</p><br>
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
        // 食品IDの実際の値
        const actualFoodId = "123456";

        // 伏字用にマスキングする
        const maskedFoodId = actualFoodId.replace(/./g, "*");

        // ページ読み込み時に伏字を表示
        document.getElementById("foodid").textContent = maskedFoodId;
    </script>
            <!-- Bootstrap JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
