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
        <h1>食品詳細</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>食品名</th>
                    <th>登録日</th>
                    <th>使い切り期限</th>
                    <th>数量</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="#" class="food-link">じゃがいも</a></td>
                    <td>2024/09/26</td>
                    <td>2024/10/12</td>
                    <td>2個</td>
                </tr>
                <tr>
                    <td><a href="#" class="food-link">じゃがいも</a></td>
                    <td>2024/09/27</td>
                    <td>2024/10/13</td>
                    <td>3個</td>
                </tr>
                <tr>
                    <td><a href="#" class="food-link">じゃがいも</a></td>
                    <td>2024/10/02</td>
                    <td>2024/10/09</td>
                    <td>3個</td>
                </tr>
                <tr>
                    <td><a href="#" class="food-link">じゃがいも</a></td>
                    <td>2024/10/03</td>
                    <td>2024/10/10</td>
                    <td>1個</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="popup" class="popup" style="display: none;">
        <div class="popup-content">
            <span id="popup-close" class="popup-close" onclick="closePopup()">×</span>
            <h2 id="popup-food-title"></h2>
            <form onsubmit="event.preventDefault(); submitForm();">
                <label for="count">個数:</label>
                <input type="text" id="count" name="count" required><br><br>
                <label for="date">日付:</label>
                <input type="date" id="date" name="date" required><br><br>
                <button type="submit">登録</button>
            </form>
        </div>
    </div>

    <script>
        // 関数: ポップアップを閉じる
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        // 関数: ポップアップを開く
        function openPopup(foodName) {
            document.getElementById("popup").style.display = "block";
            document.getElementById("popup-food-title").innerText = foodName;
        }

        // 全ての食品リンクにクリックイベントを追加
        document.addEventListener("DOMContentLoaded", () => {
            const foodLinks = document.querySelectorAll(".food-link");
            foodLinks.forEach(link => {
                link.addEventListener("click", (event) => {
                    event.preventDefault(); // デフォルトのリンク動作を無効化
                    const foodName = link.textContent.trim();
                    openPopup(foodName);
                });
            });
        });

        // フォーム送信処理
        function submitForm() {
            const count = document.getElementById("count").value;
            const date = document.getElementById("date").value;
            alert(`個数: ${count}\n日付: ${date} を登録しました！`);
            closePopup();
        }
    </script>

    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 20px;
            border-radius: 8px;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .popup-content h2 {
            margin-top: 0;
        }
    </style>
</body>

</html>
