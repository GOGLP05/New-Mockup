<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_list_of_seasonings.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>調味料一覧</title>
    <style>
       

    </style>
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a>>
        <span>調味料一覧</span>
    </ul>

    <h1>調味料一覧</h1>

    <div class="button-container">
        <a href="admin_seasoning_detail.php">
            <button>新規登録</button>
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>調味料ID</th>
                <th>調味料名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>5001</td>
                <td>だし</td>
                <td><input type="button" onclick="location.href='admin_food_registration.php'" value="詳細"></td>
            </tr>
            <tr>
                <td>5002</td>
                <td>油</td>
                <td><input type="button" onclick="location.href='admin_food_registration.php'" value="詳細"></td>
            </tr>
            <tr>
                <td>5003</td>
                <td>醤油</td>
                <td><input type="button" onclick="location.href='admin_food_registration.php'" value="詳細"></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
