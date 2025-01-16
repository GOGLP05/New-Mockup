<?php
require_once 'helpers/RegisteredFoodDAO.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header('Location: login.php'); // ログインページへリダイレクト
    exit;
}

$member_id = $_SESSION['member_id'];
$RegisteredFood = new RegisteredFoodDAO();

// 食品名とlotnoを取得
$food_name = $_GET['food_name'] ?? null;
$lotno = $_GET['lotno'] ?? null;

if (!$food_name || !$lotno) {
    header('Location: list_of_food.php'); // 必要なデータがない場合はリストに戻る
    exit;
}

// 指定された食品名とlotnoに基づいてデータを取得
$food_detail = $RegisteredFood->get_food_detail_by_name_and_lotno($food_name, $lotno, $member_id);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="food_detail.css">
    <title>食品詳細</title>
</head>

<body>
    <div class="content">
        <h1>食品詳細</h1>

        <?php if (!empty($food_detail)) : ?>
            <h4>食品名: <?php echo htmlspecialchars($food_detail['food_name'], ENT_QUOTES, 'UTF-8'); ?></h4>
            <table border="1">
                <tr>
                    <th>登録日</th>
                    <td><?php echo htmlspecialchars($food_detail['registration_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>使い切り期限</th>
                    <td><?php echo htmlspecialchars($food_detail['expire_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>数量</th>
                    <td><?php echo htmlspecialchars($food_detail['amount'], ENT_QUOTES, 'UTF-8'); ?>個</td>
                </tr>
                <tr>
                    <th>ロット番号</th>
                    <td><?php echo htmlspecialchars($food_detail['lotno'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            </table>
        <?php else : ?>
            <p>指定された食品のデータが見つかりません。</p>
        <?php endif; ?>

        <a href="list_of_food.php">戻る</a>
    </div>
</body>

</html>