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
            <li><a class="menu__item" href="food_registration.php">食品登録</a></li>
            <li><a class="menu__item" href="setting.php">設定</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="tape">
            <h1>作れる料理</h1>
        </div>
        <div class="dishes_can_make">
            <a href="recipe_detail.php">
                <div class="image-container">
                    <img src="img/nikujaga.jpg" alt="肉じゃが">
                    <div class="image-text">肉じゃが</div>
                </div>
            </a>
            <a href="recipe_detail.php">
                <div class="image-container">
                    <img src="img/hamburg steak.jpg" alt="ハンバーグ">
                    <div class="image-text">ハンバーグ</div>
                </div>
            </a>
            <a href="recipe_detail.php">
                <div class="image-container">
                    <img src="img/spaghetti.jpg" alt="ミートスパゲティ">
                    <div class="image-text">ミートスパゲティ</div>
                </div>
            </a>
            <a href="recipe_detail.php">
                <div class="image-container">
                    <img src="img/potato gratin.jpg" alt="じゃがいもグラタン">
                    <div class="image-text">じゃがいもグラタン</div>
                </div>
            </a>
            <a href="recipe_detail.php">
                <div class="image-container">
                    <img src="img/candied_sweet potato.jpg" alt="大学芋">
                    <div class="image-text">大学芋</div>
                </div>
            </a>
            <a href="recipe_detail.php">
                <div class="image-container">
                    <img src="img/simmered.jpg" alt="煮物">
                    <div class="image-text">煮物</div>
                </div>
            </a>
        </div>

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
                    <tr>
                        <td>じゃがいも</td>
                        <td>3個</td>
                        <td>あと3日</td>
                    </tr>
                    <tr>
                        <td>さつまいも</td>
                        <td>5個</td>
                        <td>あと4日</td>
                    </tr>
                    <tr>
                        <td>里芋</td>
                        <td>3個</td>
                        <td>あと4日</td>
                    </tr>
                    <tr>
                        <td>玉ねぎ</td>
                        <td>2個</td>
                        <td>あと6日</td>
                    </tr>
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
                    <tr>
                        <td>牛乳</td>
                        <td>1本</td>
                        <td>3日</td>
                    </tr>
                    <tr>
                        <td>木綿豆腐</td>
                        <td>1丁</td>
                        <td>3日</td>
                    </tr>
                    <tr>
                        <td>みょうが</td>
                        <td>1個</td>
                        <td>4日</td>
                    </tr>
                    <tr>
                        <td>納豆</td>
                        <td>3個</td>
                        <td>6日</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
