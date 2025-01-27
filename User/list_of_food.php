<?php
require_once 'helpers/RegisteredFoodDAO.php';
require_once 'helpers/CategoryDAO.php';
require_once 'helpers/FoodMasterDAO.php';
session_start();

if (!isset($_SESSION['member_id'])) {
    header('Location: login.php'); // ログインページへリダイレクト
    exit;
}

$member_id = $_SESSION['member_id'];
$RegisteredFood = new RegisteredFoodDAO();
$CategoryDAO = new CategoryDAO();
$FoodMasterDAO = new FoodMasterDAO();

// 食品名が指定されている場合、その食品のみを取得
$food_name = $_GET['food_name'] ?? null;

if ($food_name) {
    // 特定の食品のデータを取得
    $foods = $RegisteredFood->get_foods_by_name_and_member($food_name, $member_id);
} else {
    // 全食品を取得
    $foods = $RegisteredFood->get_all_foods_by_member($member_id);
}

// 最大公約数 (GCD) を求める関数
function gcd($a, $b)
{
    // Cast $a and $b to integers
    $a = (int)$a;
    $b = (int)$b;

    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

// 割り算の結果を分数形式に変換（整数部分も扱えるように変更）
function convertToFraction($numerator, $denominator)
{
    // GCDを求める
    $gcd = gcd($numerator, $denominator);

    // 分子と分母を簡約化
    $simplified_numerator = $numerator / $gcd;
    $simplified_denominator = $denominator / $gcd;

    // 分母が7以上の場合、小数表示にする
    if ($simplified_denominator >= 7) {
        return round($numerator / $denominator, 2); // 小数第2位まで表示
    }

    // 整数部分と分数部分を分ける
    $integer_part = floor($simplified_numerator / $simplified_denominator);
    $remainder_numerator = $simplified_numerator % $simplified_denominator;

    // 整数部分があれば「個と」形式で、なければ単に分数を表示
    if ($integer_part > 0 && $remainder_numerator > 0) {
        return $integer_part . '個と' . $remainder_numerator . '/' . $simplified_denominator;
    } elseif ($integer_part > 0) {
        return $integer_part;
    } elseif ($remainder_numerator > 0) {
        return $remainder_numerator . '/' . $simplified_denominator;
    } else {
        return '0個'; // 数量が0の場合
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="list_of_food.css">
    <title>食品庫</title>
</head>

<body>
    <div class="hamburger-menu"></div>
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
        <span></span>
    </label>

    <ul class="menu__box">
        <li><a class="menu__item" href="top.php">TOP</a></li>
        <li><a class="menu__item" href="list_of_food.php">食品庫</a></li>
        <li><a class="menu__item" href="recipe_list.php">レシピ一覧</a></li>
        <li><a class="menu__item" href="food_registration.php">食品登録</a></li>
        <li><a class="menu__item" href="setting.php">設定</a></li>
    </ul>

    <div class="content">
        <h1>食品庫</h1>

        <?php if ($food_name) : ?>
            <h4>「<?php echo htmlspecialchars($food_name, ENT_QUOTES, 'UTF-8'); ?>」の一覧を表示しています</h4>
            <a href="list_of_food.php">全ての食品を見る</a>
        <?php else : ?>
            <h4>直近に登録された食品のみを表示しています</h4>
        <?php endif; ?>

        <table border="1">
            <thead>
                <tr>
                    <th>食品名</th>
                    <th>登録日(直近)</th>
                    <th>使い切り期限(直近)</th>
                    <th>数量(合計)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($foods)) : ?>
                    <?php foreach ($foods as $food) : ?>
                        <tr>
                            <td>
                                <a href="list_of_food.php?food_name=<?php echo urlencode($food['food_name'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($food['food_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($food['registration_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($food['expire_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php
                                // food_amount または standard_gram を選択
                                if ($food['total_amount'] == "") {
                                    $amount = $food['total_gram'];
                                } else {
                                    $amount = $food['total_gram'] / $food['standard_gram'];
                                }

                                // 数値かつ整数であれば整数に切り捨て
                                if (is_numeric($amount)) {
                                    if (floor($amount) == $amount) {
                                        $formattedAmount = intval($amount);  // 整数に変換
                                    } else {
                                        // 分数形式に変換
                                        $formattedAmount = convertToFraction($food['total_gram'], $food['standard_gram']);
                                    }
                                }
                                ?>
                                <?= htmlspecialchars($formattedAmount, ENT_QUOTES, 'UTF-8') ?>
                                <?php echo htmlspecialchars($CategoryDAO->get_use_unit_by_category_id($food['category_id']) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">データがありません。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>