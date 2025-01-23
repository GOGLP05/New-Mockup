<?php
require_once 'helpers/FoodMasterDAO.php';

$FoodMasterDAO = new FoodMasterDAO();

// カテゴリをデータベースから取得
$categories = $FoodMasterDAO->get_all_categories();

// カテゴリIDの配列を作成
$category_ids = [];
foreach ($categories as $category) {
    $category_ids[$category['category_name']] = $category['category_id'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームから送信されたデータを取得
    $food_id = $_POST['food_id'] ?? null; // 食品ID
    $food_name = $_POST['foodname'] ?? ''; // 食品名
    $standard_gram = $_POST['standardgrams'] ?? ''; // 基準グラム数
    $expiry_date = $_POST['deadline'] ?? ''; // 賞味期限
    $unit = $_POST['unit'] ?? ''; // 単位
    $category_name = $_POST['category'] ?? ''; // カテゴリ名

    // カテゴリIDを取得
    $category_id = isset($category_ids[$category_name]) ? $category_ids[$category_name] : '';

    // 画像のアップロード処理
    $food_file_path = '';
    if (isset($_FILES['food_file_path']) && $_FILES['food_file_path']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['food_file_path']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['food_file_path']['tmp_name'], $file_path)) {
            $food_file_path = $file_path;
        }
    }

    // 「更新」ボタンが押された場合
    if (isset($_POST['update'])) {
        // 食品IDが存在する場合、更新処理
        if ($food_id) {
            $existing_food = $FoodMasterDAO->get_food_by_name($food_name);
            if ($existing_food && $existing_food->food_id !== $food_id) {
                echo "この食品名はすでに存在します。";
            } else {
                // 更新処理
                $FoodMasterDAO->update_food($food_id, $food_name, $expiry_date, $food_file_path, $category_id, $standard_gram, $category_name);
                header("Location: admin_list_of_food.php");
                exit;
            }
        }
    }
    // 「追加」ボタンが押された場合
    else if (isset($_POST['add'])) {
        // 新規追加処理
        if ($food_name) {
            if ($FoodMasterDAO->check_if_food_exists($food_name)) {
                echo "この食品名はすでに存在します。";
            } else {
                $food_id = $FoodMasterDAO->get_next_food_id();
                $FoodMasterDAO->insert_food($food_name, $expiry_date, $food_file_path, $category_id, $standard_gram, $category_name);
                header("Location: admin_list_of_food.php");
                exit;
            }
        }
    }
}


// 編集の場合、指定された食品IDを取得
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    $food_details = $FoodMasterDAO->get_food_by_id($food_id);
} else {
    // 新規登録の場合、次の食品IDを設定
    $food_id = $FoodMasterDAO->get_next_food_id();
    $food_details = (object) [
        'food_name' => '',
        'standard_gram' => '',
        'expiry_date' => '',
        'category_id' => '',
        'food_file_path' => ''  // 新規登録の場合は空のデフォルト値
    ];
}

$food_name = $food_details->food_name ?? '';
$standard_gram = $food_details->standard_gram ?? '';
$expiry_date = $food_details->expiry_date ?? '';
$food_file_path = $food_details->food_file_path ?? '';
$category_id = $food_details->category_id ?? '';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品登録/編集</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_food_registration.css">
</head>
<body>
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <a href="admin_list_of_food.php">食品一覧</a> >
        <span>食品登録/編集</span>
    </ul>

    <h1>食品登録/編集</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container">
            <input type="hidden" name="food_id" value="<?= htmlspecialchars($food_id, ENT_QUOTES, 'UTF-8') ?>">

            <label for="foodname">食品名:</label>
            <input type="text" id="foodname" name="foodname" value="<?= htmlspecialchars($food_details->food_name ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="食品名を入力">

            <label for="standardgrams">基準グラム:</label>
            <input type="text" id="standardgrams" name="standardgrams" value="<?= htmlspecialchars($food_details->standard_gram ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="基準グラムを入力">

            <label for="deadline">使い切り期限:</label>
            <input type="text" id="deadline" name="deadline" value="<?= htmlspecialchars($food_details->expiry_date ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="使い切り期限を入力">

            <label for="unit">単位:</label>
            <select name="unit" id="unit">
                <option value="g">g</option>
                <option value="個">個</option>
                <option value="本">本</option>
                <option value="枚">枚</option>
                <option value="パック">パック</option>
                <option value="束">束</option>
                <option value="玉">玉</option>
                <option value="株">株</option>
                <option value="節">節</option>
                <option value="匹">匹</option>
            </select>

            <label for="category_name">カテゴリ:</label>
            <select name="category" id="category">
                <?php foreach ($category_ids as $name => $id): ?>
                    <option value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" <?= ($food_details->category_id == $id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="food_file_path">食品写真:</label>
            <input type="file" id="food_file_path" name="food_file_path" style="display: none;" accept="image/*">
            <button type="button" id="uploadBtn">アップロード</button>

            <div id="previewContainer" style="display: none;">
                <h3>選択した画像:</h3>
                <img id="previewImg" src="" alt="Selected Image" style="max-width: 100%; height: auto;">
            </div>

            <div class="button-container">
                <?php if (isset($food_details->food_name) && empty($food_details->food_name)): ?>
                    <!-- 新規登録ボタン（追加） -->
                    <button type="submit" class="btn btn-success" name="add">追加</button>
                <?php else: ?>
                    <!-- 更新ボタン -->
                    <button type="submit" class="btn btn-primary" name="update">更新</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('uploadBtn').addEventListener('click', function() {
            document.getElementById('food_file_path').click();
        });

        document.getElementById('food_file_path').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var previewImg = document.getElementById('previewImg');
                    previewImg.src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

</body>
</html>
