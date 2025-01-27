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
if (!$food_name) {
    header('Location: list_of_food.php'); // 食品名がない場合は一覧ページにリダイレクト
    exit;
}

// 特定の食品のデータを取得
$foods = $RegisteredFood->get_foods_by_name_and_member($food_name, $member_id);

// 表示するデータがない場合はlist_of_food.phpにリダイレクト
if (empty($foods)) {
    header('Location: list_of_food.php');
    exit;
}

// 食品名が指定されている場合、その食品のみを取得
$food_name = $_GET['food_name'] ?? null;
if (!$food_name) {
    header('Location: list_of_food.php'); // 食品名がない場合は一覧ページにリダイレクト
    exit;
}

// 特定の食品のデータを取得
$foods = $RegisteredFood->get_foods_by_name_and_member($food_name, $member_id);

if (empty($foods)) {
    echo "該当する食品が見つかりませんでした。";
    exit;
}

// 最大公約数 (GCD) を求める関数
function gcd($a, $b)
{
    $a = (int)$a;
    $b = (int)$b;
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

// 割り算の結果を分数形式に変換
function convertToFraction($numerator, $denominator)
{
    $gcd = gcd($numerator, $denominator);
    $simplified_numerator = $numerator / $gcd;
    $simplified_denominator = $denominator / $gcd;

    if ($simplified_denominator >= 7) {
        return round($numerator / $denominator, 2);
    }

    $integer_part = floor($simplified_numerator / $simplified_denominator);
    $remainder_numerator = $simplified_numerator % $simplified_denominator;

    if ($integer_part > 0 && $remainder_numerator > 0) {
        return $integer_part . '個と' . $remainder_numerator . '/' . $simplified_denominator;
    } elseif ($integer_part > 0) {
        return $integer_part;
    } elseif ($remainder_numerator > 0) {
        return $remainder_numerator . '/' . $simplified_denominator;
    } else {
        return '0個';
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
    <title>食品詳細</title>
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
        <h1>食品詳細</h1>

        <h4>「<?php echo htmlspecialchars($food_name, ENT_QUOTES, 'UTF-8'); ?>」の詳細情報</h4>

        <table border="1">
            <thead>
                <tr>
                    <th>食品名</th>
                    <th>登録日時</th>
                    <th>使い切り期限</th>
                    <th>数量</th>
                    <th>操作</th> <!-- 操作列を追加 -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foods as $food) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($food['food_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php
                            if (isset($food['lot_no'])) {
                                $lotNo = new DateTime($food['lot_no']);
                                echo htmlspecialchars($lotNo->format('Y-m-d H:i'), ENT_QUOTES, 'UTF-8');
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($food['expire_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php
                            if ($food['food_amount'] == "") {
                                $amount = $food['standard_gram'];
                            } else {
                                $amount = $food['standard_gram'] / $food['food_standard_gram'];
                            }

                            if (is_numeric($amount)) {
                                if (floor($amount) == $amount) {
                                    $formattedAmount = intval($amount);
                                } else {
                                    $formattedAmount = convertToFraction($food['standard_gram'], $food['food_standard_gram']);
                                }
                            }
                            ?>
                            <?= htmlspecialchars($formattedAmount, ENT_QUOTES, 'UTF-8') ?>
                            <?php echo htmlspecialchars($CategoryDAO->get_use_unit_by_category_id($food['category_id']) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <!-- 編集ボタン -->
                            <!--<button class="change_amount"> 数量変更</button>めんどくさそ-->
                            <!-- 削除ボタン -->
                            <button class="delete" onclick="confirmDelete('<?php echo htmlspecialchars($food['lot_no'], ENT_QUOTES, 'UTF-8'); ?>')">削除</button>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="list_of_food.php">食品庫に戻る</a>
    </div>

</body>

</html>

<script>
function confirmDelete(lot_no) {
    if (confirm("本当に削除しますか？")) {
        // 削除処理を実行
        window.location.href = `helpers/delete_food.php?lot_no=${lot_no}`;
    }
}
</script>