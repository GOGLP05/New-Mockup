<?php
require_once 'helpers/SeasoningMasterDAO.php';

$SeasoningMasterDAO = new SeasoningMasterDAO();

// URL パラメータから調味料IDを取得
$seasoning_id = $_GET['seasoning_id'] ?? $_POST['seasoning_id'] ?? null;

if (!$seasoning_id) {
    // 新規作成の場合
    $seasoning = new stdClass();
    $seasoning->seasoning_name = ""; // 名前は空

    // 新規作成時にIDを設定
    $dbh = DAO::get_db_connect();
    $sql = "SELECT MAX(seasoning_id) AS max_id FROM seasoning_master";
    $stmt = $dbh->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // 最大のIDを取得し、新しいIDを作成
    if ($row && $row['max_id']) {
        $max_id = (int)$row['max_id'];
        $seasoning->seasoning_id = str_pad($max_id + 1, 8, "0", STR_PAD_LEFT);
    } else {
        // 最初のIDを設定
        $seasoning->seasoning_id = "50000001"; // 初期ID
    }
} else {
    // 既存の調味料情報を取得
    $seasoning = $SeasoningMasterDAO->get_seasoning_by_id($seasoning_id);

    // データが存在しない場合の処理
    if (!$seasoning) {
        $seasoning = new stdClass();
        $seasoning->seasoning_id = null;
        $seasoning->seasoning_name = "";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seasoning_name = $_POST['seasoning_name'] ?? null;
    $seasoning_id = $_POST['seasoning_id'] ?? null;
    // seasoning_idが存在する場合のみ更新処理
   // if ($seasoning_id) {
        // 更新ボタンが押された場合
        if (isset($_POST['update'])) {
            if ($seasoning_name) {
                $existing_seasoning = $SeasoningMasterDAO->get_seasoning_by_name($seasoning_name);
                if ($existing_seasoning && $existing_seasoning->seasoning_id !== $seasoning_id) {
                    echo "この調味料名は既に存在します。";
                } else {
                    // 更新処理
                    $SeasoningMasterDAO->update_seasoning($seasoning_id, $seasoning_name);
                    header('Location: admin_list_of_seasonings.php');
                    exit;
                }
            }
        }
    //}
    // seasoning_idがない場合は新規追加処理
    else if (isset($_POST['add'])) {
        var_dump($seasoning_name);

        // 新規追加処理
        if ($seasoning_name) {
            if ($SeasoningMasterDAO->check_if_seasoning_exists($seasoning_name)) {
                echo "この調味料名はすでに存在します。";
            } else {
                $SeasoningMasterDAO->insert_seasoning($seasoning_id, $seasoning_name);
                //header('Location: admin_list_of_seasonings.php');
                //exit;
            }
        }
    }
}

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // 削除対象のIDを取得
    $delete_seasoning_id = $_POST['seasoning_id'];

    // 削除実行
    $SeasoningMasterDAO->delete_seasoning_by_id($delete_seasoning_id);

    // 削除後、リストページにリダイレクト
    header('Location: admin_list_of_seasonings.php');
    exit;
}
?>


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
        <span>調味料詳細</span>
    </ul>

    <h1>調味料詳細</h1>
    <div>
        <label for="tyoumiryouid">調味料ID:</label>
        <div class="masked-text" id="tyoumiryouid">
            <?= htmlspecialchars($seasoning->seasoning_id ?? "不明", ENT_QUOTES, 'UTF-8') ?>
        </div>
    </div>
    <!-- 更新/追加フォーム -->
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>">
        <div>
            <label for="tyoumiryouname">調味料名:</label>
            <input type="text" id="tyoumiryouname" name="seasoning_name" value="<?= htmlspecialchars($seasoning->seasoning_name ?? "", ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <?php if ($seasoning->seasoning_id): ?>
        <input type="hidden" name="seasoning_id" value="<?= htmlspecialchars($seasoning->seasoning_id ?? "", ENT_QUOTES, 'UTF-8') ?>">
        <?php endif; ?>

            <div class="button-container">
            <?php if (!empty($seasoning->seasoning_id) && $seasoning_id): ?>
                <!-- 更新ボタン -->
                <button type="submit" class="btn btn-primary" name="update">更新</button>
            <?php else: ?>
                <!-- 追加ボタン -->
                <button type="submit" class="btn btn-success" name="add">追加</button>
            <?php endif; ?>
        </div>    
    </form>

    <!-- 削除ボタン（モーダル） -->
    <div class="button-container">
        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#Modal">削除</button>
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
                        <input type="hidden" name="seasoning_id" value="<?= htmlspecialchars($seasoning->seasoning_id ?? "", ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="delete" value="1"> <!-- 削除を指示するための隠しフィールド -->
                        <p>調味料 <?= htmlspecialchars($seasoning->seasoning_name ?? "不明", ENT_QUOTES, 'UTF-8') ?> を削除します。</p>
                        <br>
                        <p>よろしいですか？</p>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">はい</button>
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
