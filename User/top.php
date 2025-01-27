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
        <div class="user-info">
    <p>ログイン中のユーザー:</p>
    <span class="email"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></span>
</div>


        <div class="tape">
            <h1>作れる料理</h1>
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

        <div>
            <h1>使い切り期限が近い食材</h1>
            <table class="expiring_soon">
                <thead>
                    <tr>
                        <th>食材名</th>
                        <th>数量</th>
                        <th>残り日数</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expiringSoonFoods)) : ?>
                        <?php foreach ($expiringSoonFoods as $food) : ?>
                            <tr>
                                <td><?= htmlspecialchars($food['food_name'] ?? '不明な食材', ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php
                                    $amount = $food['food_amount'] ?? $food['standard_gram'];
                                    $formattedAmount = (is_numeric($amount) && floor($amount) == $amount) 
                                        ? intval($amount) 
                                        : $amount;
                                    ?>
                                    <?= htmlspecialchars($formattedAmount, ENT_QUOTES, 'UTF-8') ?>
                                    <?php echo htmlspecialchars($CategoryDAO->get_use_unit_by_category_id($food['category_id']) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td>
                                    <?php
                                    $expireDate = new DateTime($food['expire_date'] ?? 'now');
                                    $today = new DateTime();
                                    $interval = $expireDate->diff($today);
                                    echo $interval->days . " 日";
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3">使い切り期限が近い食材はありません。</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div>
            <h1>使い切り期限が過ぎた食材</h1>
            <table class="expired">
                <thead>
                    <tr>
                        <th>食材名</th>
                        <th>数量</th>
                        <th>経過日数</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expiredFoods)) : ?>
                        <?php foreach ($expiredFoods as $food) : ?>
                            <tr>
                                <td><?= htmlspecialchars($food['food_name'] ?? '不明な食材', ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php
                                    $amount = $food['food_amount'] ?? $food['standard_gram'];
                                    $formattedAmount = (is_numeric($amount) && floor($amount) == $amount) 
                                        ? intval($amount) 
                                        : $amount;
                                    ?>
                                    <?= htmlspecialchars($formattedAmount, ENT_QUOTES, 'UTF-8') ?>
                                    <?php echo htmlspecialchars($CategoryDAO->get_use_unit_by_category_id($food['category_id']) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td>
                                    <?php
                                    $expireDate = new DateTime($food['expire_date'] ?? 'now');
                                    $today = new DateTime();
                                    $interval = $expireDate->diff($today);
                                    echo $interval->days . " 日";
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3">期限が過ぎた食材はありません。</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
    </div>
</body>

</html>
