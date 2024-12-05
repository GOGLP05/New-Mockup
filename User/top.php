<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOP</title>
    <link rel="stylesheet" href="TOP.css">
</head>
<body>


    <div class="hamburger-menu">
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
    <span></span>
    </label>

        <ul class="menu__box">
            <li><a class="menu__item" href="setting.html">設定</a></li>
            <li><a class="menu__item" href="list_of_food.html">食品庫</a></li>
            <li><a class="menu__item" href="food_registration.html">食品登録</a></li>
            <li><a class="menu__item" href="top.html">TOP</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>作れる料理</h1>
        <div class="dishes_can_make">
            <a href="recipe_detail.html"><img src="img/nikujaga.jpg" alt="肉じゃが"></a>
            <a href="recipe_detail.html"><img src="img/hamburg steak.jpg" alt="ハンバーグ"></a>
            <a href="recipe_detail.html"><img src="img/spaghetti.jpg" alt="ミートスパゲティ"></a>
            <a href="recipe_detail.html"><img src="img/potato gratin.jpg" alt="じゃがいもグラタン"></a>
            <a href="recipe_detail.html"><img src="img/candied_sweet potato.jpg" alt="大学芋"></a>
            <a href="recipe_detail.html"><img src="img/simmered.jpg" alt="煮物"></a>
        </div>

        <h1>使い切り期限が近い食材</h1>
        <table>
            <thead>
                <tr>
                    <td>じゃがいも</td>
                    <td>3個</td>
                    <td>あと3日</td>
                </tr>
            </thead>
            <tbody>
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

        <h1>使い切り期限が過ぎた食材</h1>
        <table>
            <thead>
                <tr>
                    <td>牛乳</td>
                    <td>1本</td>
                    <td>3日前</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>木綿豆腐</td>
                    <td>1丁</td>
                    <td>3日前</td>
                </tr>
                <tr>
                    <td>みょうが</td>
                    <td>1個</td>
                    <td>4日前</td>
                </tr>
                <tr>
                    <td>納豆</td>
                    <td>3個</td>
                    <td>6日前</td>
                </tr>
            </tbody>
        </table>
        
    </div>

</body>
</html>
