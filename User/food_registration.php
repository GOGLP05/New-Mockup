<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="food_registration.css">
    <title>食品登録</title>
    <script src="pop_up.js"></script>
</head>
<body>
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

    <div class="content">
        <h1>食品登録</h1>
        <div class="recent_registration">
            <input type="button" onclick="location.href='recent_food_registration.php'" value="最近登録した食品">
        </div>
    </div>

    <hr>
    <div class="content">
        <div class="foods">
            <button class="button" onclick="showPopup('牛肉')" title="牛肉">
                <img src="img/foods/20000001.jpg" alt="牛肉" class="food-image">
            </button>
            <button class="button" onclick="showPopup('鶏肉')" title="鶏肉">
                <img src="img/foods/20000002.jpg" alt="鶏肉" class="food-image">
            </button>
            <button class="button" onclick="showPopup('豚肉')" title="豚肉">
                <img src="img/foods/20000002.jpg" alt="豚肉" class="food-image">
            </button>
            <button class="button" onclick="showPopup('野菜')" title="野菜">
                <img src="img/foods/20000002.jpg" alt="野菜" class="food-image">
            </button>
            <button class="button" onclick="showPopup('魚')" title="魚">
                <img src="img/foods/20000002.jpg" alt="魚" class="food-image">
            </button>
            <button class="button" onclick="showPopup('卵')" title="卵">
                <img src="img/foods/20000002.jpg" alt="卵" class="food-image">
            </button>
            <button class="button" onclick="showPopup('米')" title="米">
                <img src="img/foods/20000002.jpg" alt="米" class="food-image">
            </button>
            <button class="button" onclick="showPopup('小麦')" title="小麦">
                <img src="img/foods/20000002.jpg" alt="小麦" class="food-image">
            </button>
            <button class="button" onclick="showPopup('豆腐')" title="豆腐">
                <img src="img/foods/20000002.jpg" alt="豆腐" class="food-image">
            </button>
            <button class="button" onclick="showPopup('じゃがいも')" title="じゃがいも">
                <img src="img/foods/20000002.jpg" alt="じゃがいも" class="food-image">
            </button>
            <button class="button" onclick="showPopup('りんご')" title="りんご">
                <img src="img/foods/20000002.jpg" alt="りんご" class="food-image">
            </button>
            <button class="button" onclick="showPopup('バナナ')" title="バナナ">
                <img src="img/foods/20000002.jpg" alt="バナナ" class="food-image">
            </button>
            <button class="button" onclick="showPopup('みかん')" title="みかん">
                <img src="images/mikan.jpg" alt="みかん" class="food-image">
            </button>
            <button class="button" onclick="showPopup('トマト')" title="トマト">
                <img src="images/tomato.jpg" alt="トマト" class="food-image">
            </button>
            <button class="button" onclick="showPopup('レタス')" title="レタス">
                <img src="images/lettuce.jpg" alt="レタス" class="food-image">
            </button>
        </div>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <h3 id="popup-food-title">食品情報を入力</h3>
            <form id="pop_up_foodregistration" method="POST" action="food_registration.php">
                <input type="hidden" id="food-name" name="food">
                <label for="quantity">グラム:</label>
                <input type="number" id="quantity" name="quantity" min="1" required><br><br>

                <label for="count">個数:</label>
                <input type="number" id="count" name="count" min="1" required><br><br>

                <label for="date">登録日:</label>
                <input type="date" id="date" name="date" required><br><br>

                <button type="submit">追加</button>
                <button type="button" onclick="closePopup()">閉じる</button>
            </form>
        </div>
    </div>
</body>
</html>
