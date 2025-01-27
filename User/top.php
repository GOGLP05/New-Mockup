<?php
session_start();

// セッションからユーザー情報を取得
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'helpers/RecipeMasterDAO.php';
require_once 'helpers/RegisteredFoodDAO.php';
require_once 'helpers/DAO.php';
require_once 'helpers/RecipeChecker.php';
require_once 'helpers/CategoryDAO.php';
require_once 'helpers/MemberDAO.php';  // MemberDAOをインクルード

// ユーザーIDを取得
$member_id = $_SESSION['member_id'];

// MemberDAOインスタンスを作成し、ユーザー情報を取得
$memberDAO = new MemberDAO();
$member = $memberDAO->get_member_by_id($member_id);  // member_idを使って情報を取得
$email = $member->email ?? 'メールアドレスが不明';  // メールアドレスが存在しない場合のデフォルトメッセージ

// RecipeCheckerインスタンスを作成し、作れるレシピを取得
$recipeChecker = new RecipeChecker();
$CategoryDAO = new CategoryDAO();
list($available_recipes, $unavailable_recipes) = $recipeChecker->getAvailableRecipes($member_id);

// ここで期限切れの食品を取得する
$foodDAO = new RegisteredFoodDAO();
$expiredFoods = $foodDAO->get_expired_foods_by_member($member_id);
$expiringSoonFoods = $foodDAO->get_expiring_soon_foods_by_member($member_id);

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
    <link rel="stylesheet" href="top.css">
    <title>TOP</title>
</head>

<body>
    <div class="hamburger-menu">
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
    </div>

    <div class="content">
        <!-- メールアドレス表示 -->


        <div class="tape">
        <h1>作れる料理</h1>
            <div class="user-info">
                <p>ログイン中のユーザー:<span class="email"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></span></p>
            </div>
        </div>

        <div class="dishes_can_make" id="dishes-container">
            <?php if (!empty($available_recipes)) : ?>
                <?php foreach ($available_recipes as $index => $recipe) : ?>
                    <a href="recipe_detail.php?id=<?= htmlspecialchars($recipe['recipe_id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        class="image-container <?= $index >= 6 ? 'hidden' : '' ?>">
                        <img src="<?= htmlspecialchars($recipe['recipe_file_path1'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            alt="<?= htmlspecialchars($recipe['recipe_name'] ?? '不明な料理', ENT_QUOTES, 'UTF-8') ?>">
                        <div class="image-text"><?= htmlspecialchars($recipe['recipe_name'] ?? '不明な料理', ENT_QUOTES, 'UTF-8') ?></div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p>作れる料理がありません。</p>
            <?php endif; ?>
        </div>
        <?php if (count($available_recipes) > 6) : ?>
            <button id="toggle-btn">すべて表示</button>
        <?php endif; ?>

        <!-- 以下、期限が近い食材や期限切れ食材のテーブル部分は変更なし -->
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toggleBtn = document.getElementById("toggle-btn");
            const hiddenItems = document.querySelectorAll(".dishes_can_make .hidden");
            let isExpanded = false;

            if (toggleBtn) {
                toggleBtn.addEventListener("click", () => {
                    hiddenItems.forEach(item => {
                        item.style.display = isExpanded ? "none" : "block";
                    });
                    toggleBtn.textContent = isExpanded ? "すべて表示" : "折り畳む";
                    isExpanded = !isExpanded;
                });
            }
        });
    </script>
</body>

</html>