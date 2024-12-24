<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食品一覧</title>
    <link rel="stylesheet" href="admin_list_of_food.css">
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <span>食品一覧</span>
    </ul>

    <h1>食品一覧</h1>

    <!-- 新規登録ボタン -->
    <div class="button-container">
        <a href="admin_food_registration.php">
            <button>新規登録</button>
        </a>
    </div>

    <!-- 食品テーブル -->
    <table>
        <thead>
            <tr>
                <th>食品ID</th>
                <th>食品名</th>
                <th>カテゴリID</th>
                <th>基準単位グラム</th>
                <th>単位</th>
                <th>使い切り期限</th>
                <th>食品写真ファイルパス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>3001</td>
                <td>牛乳</td>
                <td>4001</td>
                <td>1000</td>
                <td>g</td>
                <td>7</td>
                <td></td>
                <td><input type="button" onclick="location.href='admin_food_registration.php'" value="編集"></td>
            </tr>
            <tr>
                <td>3002</td>
                <td>卵</td>
                <td>4002</td>
                <td>60</td>
                <td>パック</td>
                <td>14</td>
                <td></td>
                <td><input type="button" onclick="location.href='admin_food_registration.php'" value="編集"></td>
            </tr>
            <tr>
                <td>3002</td>
                <td>豆腐</td>
                <td>4003</td>
                <td>300</td>
                <td>丁</td>
                <td>10</td>
                <td></td>
                <td><input type="button" onclick="location.href='admin_food_registration.php'" value="編集"></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
